<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'fare_cny' => 'decimal:2',
        'cancelled_at' => 'datetime'
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public static function seatsBooked($departureCode)
    {
        return static::whereDepartureCode($departureCode)->whereStatus('confirmed')->sum('seats');
    }

    public static function generateCode()
    {
        do {
            $code = 'HPF' . strtoupper(str()->random(6));
        } while (static::whereBookingCode($code)->exists());

        return $code;
    }

    public static function lookup($bookingCode, $firstName, $lastName)
    {
        return static::whereBookingCode($bookingCode)->whereRaw('LOWER(first_name) = ?', [strtolower(trim($firstName))])->whereRaw('LOWER(last_name) = ?', [strtolower(trim($lastName))])->firstOrFail();
    }

    public function departsAt()
    {
        return Carbon::parse($this->departure_date . ' ' . $this->departure_time);
    }
}
