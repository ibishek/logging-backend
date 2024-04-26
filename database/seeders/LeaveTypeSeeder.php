<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Annual Leave',
                'slug' => 'annual-leave',
            ],
            [
                'name' => 'Sick Leave',
                'slug' => 'sick-leave',
            ],
            [
                'name' => 'Festival Leave',
                'slug' => 'festival-leave',
            ],
            [
                'name' => 'Maternity Leave',
                'slug' => 'maternity-leave',
            ],
            [
                'name' => 'Paternity Leave',
                'slug' => 'paternity-leave',
            ],
            [
                'name' => 'Mourning Leave',
                'slug' => 'mourning-leave',
            ],
            [
                'name' => 'Unpaid Leave',
                'slug' => 'unpaid-leave',
            ],
        ];

        array_walk($types, fn ($type) => LeaveType::create($type));
    }
}
