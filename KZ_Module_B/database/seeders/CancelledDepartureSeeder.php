<?php

namespace Database\Seeders;

use App\Models\CancelledDeparture;
use App\Models\Line;
use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancelledDepartureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = array_map('str_getcsv', file(database_path('data/cancelled_departures.csv'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $header = array_shift($rows);

        foreach ($rows as $row)
        {
            $row = array_combine($header, $row);

            $line = Line::whereCode($row['line_code'])->first();

            CancelledDeparture::create([
                'departure_code' => $line->departureCode($row['departure_date'], $row['departure_time'], Station::whereCode($row['departure_station'])->first()),
                'line_id' => $line->id,
                'departure_date' => $row['departure_date'],
                'reason' => $row['reason'],
                'cancelled_at' => $row['cancelled_at']
            ]);
        }
    }
}
