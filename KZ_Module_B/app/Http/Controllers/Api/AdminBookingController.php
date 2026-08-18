<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'date' => 'date_format:Y-m-d',
            'line_code' => 'exists:lines,code',
            'status' => 'in:confirmed,cancelled',
            'search' => 'string',
            'page' => 'integer|min:1'
        ]);

        $bookings = Booking::whereDepartureDate($data['date'] ?? now()->toDateString())->when($data['line_code'] ?? null, fn ($query, $code) => $query->whereRelation('line', 'code', $code))
            ->when($data['status'] ?? null, fn ($query, $status) => $query->whereStatus($status))->when($data['search'] ?? null, fn ($query, $search) => $query->where(fn ($searchQuery) => $searchQuery->where('booking_code', 'like', "%$search%")->orWhere('first_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%")->orWhere('email', 'like', "%$search%")))
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->orderBy('booking_code')
            ->paginate(15);

        return response()->json([
            'data' => BookingResource::collection($bookings->items()),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'per_page' => $bookings->perPage(),
                'total' => $bookings->total()
            ]
        ]);
    }
}
