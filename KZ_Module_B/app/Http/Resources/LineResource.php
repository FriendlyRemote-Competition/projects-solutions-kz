<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'status' => $this->status,
            'station_a' => [
                'code' => $this->stationA->code,
                'name' => $this->stationA->name
            ],
            'station_b' => [
                'code' => $this->stationB->code,
                'name' => $this->stationB->name,
            ],
            'seat_capacity' => $this->seat_capacity,
            'crossing_minutes' => $this->crossing_minutes,
            'fare_cny' => $this->fare_cny,
            'service_windows' => $this->serviceWindows->map(function ($window) {
                return [
                    'start_time' => substr($window->start_time, 0, 5),
                    'end_time' => substr($window->end_time, 0, 5),
                    'interval_minutes' => $window->interval_minutes
                ];
            })
        ];
    }
}
