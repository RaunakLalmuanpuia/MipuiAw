<?php

namespace Database\Seeders;

use App\Models\MaximumDay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaximumDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maximum_days = [
            [
                'label' => 'Maximum days for Department Nodal',
                'maximum_days' =>15,
            ]
            ];

        foreach($maximum_days as $max){
            MaximumDay::create($max);
        }
    }
}
