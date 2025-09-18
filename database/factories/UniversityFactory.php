<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{public function definition()
    {
        return [
            'uni_name' => $this->faker->company . ' University',
            'uni_address' => $this->faker->address,
            'campus' => $this->faker->city . ' Campus',
            'website' => $this->faker->url,
            'uni_type' => $this->faker->randomElement(['Public', 'Private']),
            'contact_no' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'admin_id' => 1,
            'state_id' => 1,
            'area_id' => 1,
        ];
    }
}
