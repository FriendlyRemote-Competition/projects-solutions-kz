<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LineResource;
use App\Models\Booking;
use App\Models\CancelledDeparture;
use App\Models\Line;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LineController extends Controller
{
    public function index()
    {
        return LineResource::collection(Line::orderBy('code')->get());
    }

    public function show(Line $line)
    {
        return new LineResource($line);
    }

    public function timetable(Line $line)
    {
        $data = request()->validate([
            'date' => 'date_format:Y-m-d',
            'station' => 'string'
        ]);

        $date = $data['date'] ?? now()->toDateString();

        $directions = [[$line->stationA, $line->stationB], [$line->stationB, $line->stationA]];

        usort($directions, fn ($first, $second) => $first[0]->code <=> $second[0]->code);

        if (isset($data['station']))
        {
            $directions = array_filter($directions, fn ($direction) => $direction[0]->code === $data['station']);

            if (!$directions)
            {
                throw ValidationException::withMessages([
                    'station' => 'Station is not part of this line'
                ]);
            }
        }

        $cancelled = CancelledDeparture::whereDepartureDate($date)->get()->keyBy('departure_code');

        $booked = Booking::whereDepartureDate($date)->whereStatus('confirmed')->groupBy('departure_code')->selectRaw('departure_code, SUM(seats) as total')->pluck('total', 'departure_code');

        $departures = [];

        foreach ($line->times() as $time)
        {
            foreach ($directions as [$origin, $destination]) {
                $code = $line->departureCode($date, $time, $origin);
                $cancellation = $cancelled->get($code);
                $seatsBooked = (int) ($booked[$code] ?? 0);

                $status = Carbon::parse($date . ' ' . $time) <= now() ? 'departed' : 'scheduled';

                if ($cancellation)
                {
                    $status = 'cancelled';
                }

                $departures[] = [
                    'code' => $code,
                    'origin' => [
                        'code' => $origin->code,
                        'name' => $origin->name,
                    ],
                    'destination' => [
                        'code' => $destination->code,
                        'name' => $destination->name,
                    ],
                    'departure_date' => $date,
                    'departure_time' => $time,
                    'arrival_time' => Carbon::parse($time)->addMinutes($line->crossing_minutes)->format('H:i'),
                    'seats_booked' => $seatsBooked,
                    'seats_available' => $line->seat_capacity - $seatsBooked,
                    'fare_cny' => $line->fare_cny,
                    'status' => $status,
                    'cancellation_reason' => $cancellation?->reason
                ];
            }
        }

        return response()->json([
            'data' => $departures
        ]);
    }
}
