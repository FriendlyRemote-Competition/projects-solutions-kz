<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'fare_cny' => 'decimal:2'
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function stationA()
    {
        return $this->belongsTo(Station::class, 'station_a_id');
    }

    public function stationB()
    {
        return $this->belongsTo(Station::class, 'station_b_id');
    }

    public function serviceWindows()
    {
        return $this->hasMany(ServiceWindow::class)->orderBy('start_time');
    }

    public function departureCode($date, $time, Station $origin)
    {
        return $this->code . '-' . str_replace('-', '', $date) . '-' . str_replace(':', '', $time) . '-' . $origin->code;
    }

    public function times()
    {
        if ($this->status === 'suspended')
        {
            return [];
        }

        $times = [];

        foreach ($this->serviceWindows as $window)
        {
            $time = Carbon::parse($window->start_time);
            $end = Carbon::parse($window->end_time);

            while ($time <= $end)
            {
                $times[] = $time->format('H:i');
                $time->addMinutes($window->interval_minutes);
            }
        }

        $times = array_values(array_unique($times));
        sort($times);

        return $times;
    }

    public static function resolve($code)
    {
        if (!preg_match('/^([A-Z]{2,4})-(\d{4})(\d{2})(\d{2})-(\d{2})(\d{2})-([A-Z]{2,4})$/', $code, $match))
        {
            return null;
        }

        $line = Line::whereCode($match[1])->first();
        $date = $match[2] . '-' . $match[3] . '-' . $match[4];
        $time = $match[5] . ':' . $match[6];

        if (!$line || !checkdate($match[3], $match[4], $match[2]) || !in_array($time, $line->times()))
        {
            return null;
        }

        if ($match[7] === $line->stationA->code)
        {
            $origin = $line->stationA;
            $destination = $line->stationB;
        } elseif ($match[7] === $line->stationB->code)
        {
            $origin = $line->stationB;
            $destination = $line->stationA;
        } else {
            return null;
        }

        return [
            'line' => $line,
            'date' => $date,
            'time' => $time,
            'origin' => $origin,
            'destination' => $destination,
            'at' => Carbon::parse($date . ' ' . $time)
        ];
    }
}
