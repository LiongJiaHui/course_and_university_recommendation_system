<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'admin_name' => $this->faker->userName(),
            'password' => bcrypt('password123'), // default test password
        ];
    }
}
