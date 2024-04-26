<?php

namespace Database\Seeders;

use App\Models\LeaveDurationType;
use Illuminate\Database\Seeder;

class LeaveDurationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Full Day',
                'slug' => 'full-day',
            ],
            [
                'name' => 'First Half',
                'slug' => 'first-half',
            ],
            [
                'name' => 'Second Half',
                'slug' => 'second-half',
            ],
        ];

        array_walk($types, fn ($type) => LeaveDurationType::create($type));
    }
}
