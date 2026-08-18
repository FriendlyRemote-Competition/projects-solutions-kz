<?php

namespace Database\Seeders;

use App\Models\Line;
use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = array_map('str_getcsv', file(database_path('data/lines.csv'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $header = array_shift($rows);

        foreach ($rows as $row)
        {
            $row = array_combine($header, $row);

            $line = Line::firstOrCreate([
                'code' => $row['line_code']
            ], [
                'name' => $row['line_name'],
                'status' => $row['line_status'],
                'station_a_id' => Station::whereCode($row['station_a_code'])->value('id'),
                'station_b_id' => Station::whereCode($row['station_b_code'])->value('id'),
                'seat_capacity' => $row['seat_capacity'],
                'crossing_minutes' => $row['crossing_minutes'],
                'fare_cny' => $row['fare_cny']
            ]);

            $line->serviceWindows()->create([
                'start_time' => $row['service_start'],
                'end_time' => $row['service_end'],
                'interval_minutes' => $row['interval_minutes']
            ]);
        }
    }
}
