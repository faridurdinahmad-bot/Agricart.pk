<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Annual', 'days_per_year' => 14, 'description' => 'Annual leave'],
            ['name' => 'Sick', 'days_per_year' => 10, 'description' => 'Sick leave'],
            ['name' => 'Casual', 'days_per_year' => 7, 'description' => 'Casual leave'],
        ];

        foreach ($types as $type) {
            LeaveType::firstOrCreate(
                ['name' => $type['name']],
                ['days_per_year' => $type['days_per_year'], 'description' => $type['description'], 'status' => 'active']
            );
        }
    }
}
