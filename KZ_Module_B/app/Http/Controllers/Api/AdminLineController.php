<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LineResource;
use App\Models\Booking;
use App\Models\Line;
use App\Models\Station;
use Illuminate\Http\Request;

class AdminLineController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'code' => 'required|regex:/^[A-Z]{2,4}$/|unique:lines,code',
            'name' => 'required|string|max:100',
            'station_a_code' => 'required|exists:stations,code|different:station_b_code',
            'station_b_code' => 'required|exists:stations,code',
            'seat_capacity' => 'required|integer|min:1|max:500',
            'crossing_minutes' => 'required|integer|min:1|max:120',
            'fare_cny' => 'required|numeric|min:0|max:999.99',
            'status' => 'in:active,suspended'
        ]);

        $line = Line::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'status' => $data['status'] ?? 'active',
            'station_a_id' => Station::whereCode($data['station_a_code'])->value('id'),
            'station_b_id' => Station::whereCode($data['station_b_code'])->value('id'),
            'seat_capacity' => $data['seat_capacity'],
            'crossing_minutes' => $data['crossing_minutes'],
            'fare_cny' => $data['fare_cny']
        ]);

        return response()->json([
            'data' => new LineResource($line)
        ], 201);
    }

    public function update(Line $line)
    {
        $data = request()->validate([
            'name' => 'required|string|max:100',
            'station_a_code' => 'required|exists:stations,code|different:station_b_code',
            'station_b_code' => 'required|exists:stations,code',
            'seat_capacity' => 'required|integer|min:1|max:500',
            'crossing_minutes' => 'required|integer|min:1|max:120',
            'fare_cny' => 'required|numeric|min:0|max:999.99',
            'status' => 'in:active,suspended'
        ]);

        $booked = Booking::whereLineId($line->id)->whereStatus('confirmed')->whereRaw("concat(departure_date, ' ', departure_time) > now()")->groupBy('departure_code')->selectRaw('sum(seats) as total')->pluck('total')->max();

        if ($booked > $data['seat_capacity'])
        {
            return response()->json([
                'message' => 'Capacity is lower than seats already booked'
            ], 422);
        }

        $line->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? 'active',
            'station_a_id' => Station::whereCode($data['station_a_code'])->value('id'),
            'station_b_id' => Station::whereCode($data['station_b_code'])->value('id'),
            'seat_capacity' => $data['seat_capacity'],
            'crossing_minutes' => $data['crossing_minutes'],
            'fare_cny' => $data['fare_cny']
        ]);

        return new LineResource($line);
    }

    public function storeWindow(Line $line)
    {
        $data = request()->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'interval_minutes' => "required|integer|min:$line->crossing_minutes|max:120"
        ]);

        $overlaps = $line->serviceWindows()->where('start_time', '<=', $data['end_time'])->where('end_time', '>=', $data['start_time'])->exists();

        if ($overlaps)
        {
            return response()->json([
                'message' => 'Service window overlaps an existing window'
            ], 422);
        }

        $line->serviceWindows()->create($data);

        return response()->json($data, 201);
    }

    public function destroyWindow(Line $line, $startTime)
    {
        $line->serviceWindows()->whereStartTime($startTime)->firstOrFail()->delete();

        return response()->json([
            'message' => 'Service window deleted'
        ]);
    }
}
