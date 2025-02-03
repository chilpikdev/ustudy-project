<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::insert([
            [
                'name' => 'php',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'laravel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sanctum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'html2pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'wordpress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'nodejs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'java',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
