<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = array_map('str_getcsv', file(database_path('data/stations.csv'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $header = array_shift($rows);

        foreach ($rows as $row)
        {
            $row = array_combine($header, $row);

            Station::create([
                'code' => $row['station_code'],
                'name' => $row['station_name'],
                'bank' => $row['bank'],
                'district' => $row['district'],
                'address' => $row['address']
            ]);
        }

    }
}
