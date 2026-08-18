<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = array_map('str_getcsv', file(database_path('data/admins.csv'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        $header = array_shift($rows);

        foreach ($rows as $row)
        {
            $row = array_combine($header, $row);

            User::create([
                'email' => $row['email'],
                'password' => $row['password'],
                'name' => $row['name'],
                'role' => $row['role'],
                'is_active' => $row['is_active']
            ]);
        }
    }
}
