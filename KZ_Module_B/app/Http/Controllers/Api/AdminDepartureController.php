<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CancelledDeparture;
use App\Models\Line;
use Illuminate\Http\Request;

class AdminDepartureController extends Controller
{
    public function cancel(string $code)
    {
        $data = request()->validate([
            'reason' => 'nullable|string|max:200'
        ]);

        $departure = Line::resolve($code) ?? abort(404);

        if (CancelledDeparture::whereDepartureCode($code)->exists())
        {
            return response()->json([
                'message' => 'Departure is already cancelled'
            ], 422);
        }

        if ($departure['at'] <= now())
        {
            return response()->json([
                'message' => 'Departure has already departed'
            ], 422);
        }

        CancelledDeparture::create([
            'departure_code' => $code,
            'line_id' => $departure['line']->id,
            'departure_date' => $departure['date'],
            'reason' => $data['reason'] ?? null,
            'cancelled_at' => now()
        ]);

        $finishData = Booking::whereDepartureCode($code)->whereStatus('confirmed')->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return response()->json([
            'data' => [
                'affected_bookings' => $finishData
            ]
        ]);
    }
}
