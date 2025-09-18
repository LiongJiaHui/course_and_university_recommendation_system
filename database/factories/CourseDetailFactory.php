<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\University;
use App\Models\Course;
use App\Models\Admin;

class CourseDetailFactory extends Factory
{
    public function definition()
    {
        return [
            'university_id' => University::factory(),
            'admin_id' => Admin::factory(),
            'course_id' => Course::factory(),
            'course_honour_name' => $this->faker->words(3, true),
            'tuition_fees' => $this->faker->numberBetween(3000, 15000), // ADD THIS
            'credit_hours' => $this->faker->numberBetween(90, 150),
            'duration' => $this->faker->numberBetween(3, 5),
            'minimum_grade' => $this->faker->randomFloat(2, 2.0, 4.0),
            'specific_subjects' => $this->faker->words(2, true),
            'merit_mark' => $this->faker->numberBetween(50, 100),
            'english_requirement_skill' => $this->faker->randomFloat(1, 3, 5),
            'ranking_qs_no_start_by_subject' => $this->faker->numberBetween(1, 20),
            'ranking_qs_no_end_by_subject' => $this->faker->numberBetween(21, 100),
            'ranking_qs_year_by_subject' => $this->faker->year(),
            'ranking_the_no_start_by_subject' => $this->faker->numberBetween(1, 20),
            'ranking_the_no_end_by_subject' => $this->faker->numberBetween(21, 100),
            'ranking_the_year_by_subject' => $this->faker->year(),
            'course_qualification' => $this->faker->boolean(),
            'course_website' => $this->faker->url(),
        ];
    }
}
