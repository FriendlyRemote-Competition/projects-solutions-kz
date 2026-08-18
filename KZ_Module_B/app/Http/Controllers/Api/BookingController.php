<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Line;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'departure_code' => 'required|string',
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:30',
            'seats' => 'required|integer|min:1|max:16'
        ]);

        $departure = Line::resolve($data['departure_code']) ?? abort(404);

        $line = $departure['line'];
        $available = $line->seat_capacity - Booking::seatsBooked($data['departure_code']);

        if ($data['seats'] > $available)
        {
            throw ValidationException::withMessages([
                'seats' => 'Not enough seats available'
            ]);
        }

        $booking = Booking::create([
            'booking_code' => Booking::generateCode(),
            'departure_code' => $data['departure_code'],
            'line_id' => $line->id,
            'departure_date' => $departure['date'],
            'departure_time' => $departure['time'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'seats' => $data['seats'],
            'fare_cny' => $line->fare_cny,
            'status' => 'confirmed'
        ]);

        return response()->json([
            'data' => new BookingResource($booking)
        ], 201);
    }

    public function lookup()
    {
        $data = request()->validate([
            'booking_code' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        return new BookingResource(Booking::lookup($data['booking_code'], $data['first_name'], $data['last_name']));
    }

    public function update(string $code)
    {
        $data = request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'seats' => 'required|integer|min:1|max:16',
        ]);

        $booking = Booking::lookup($code, $data['first_name'], $data['last_name']);

        if ($booking->status === 'cancelled')
        {
            return response()->json([
                'message' => 'Booking is already cancelled'
            ], 422);
        }

        $available = $booking->line->seat_capacity - Booking::seatsBooked($booking->departure_code) + $booking->seats;

        if ($data['seats'] > $available)
        {
            throw ValidationException::withMessages([
                'seats' => 'Not enough seats available'
            ]);
        }

        $booking->update([
            'seats' => $data['seats']
        ]);

        return new BookingResource($booking);
    }

    public function cancel(string $code)
    {
        $data = request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $booking = Booking::lookup($code, $data['first_name'], $data['last_name']);

        if ($booking->status === 'cancelled')
        {
            return response()->json([
                'message' => 'Booking is already cancelled'
            ], 422);
        }

        if ($booking->departsAt()->subMinutes(5) <= now())
        {
            return response()->json([
                'message' => 'Booking closed for this departure'
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return new BookingResource($booking);
    }
}
