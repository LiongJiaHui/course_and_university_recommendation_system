<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            'Johor',
            'Kedah',
            'Kelantan',
            'Wilayah Persekutuan Kuala Lumpur',
            'Wilayah Persekutuan Labuan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Wilayah Persekutuan Putrajaya',
            'Sabah',
            'Sarawak',
            'Selangor',
            'Terengganu',
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'state_name' => $state,
            ]);
        }
    }
}
