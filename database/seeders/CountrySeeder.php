<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::insert([
            [
                'name' => 'Uzbekistan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kazakhstan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
