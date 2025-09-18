<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class CourseCreationUnitTest extends TestCase
{
     /** @test */
    public function validation_passes_with_valid_data()
    {
        $data = [
            'course_honour_name' => 'Bachelor of Testing',
            'tuition_fees' => 10000,
            'credit_hours' => 12,
            'duration' => 3,
            'minimum_grade' => 3.0,
            'english_requirement_skill' => 4.0,
            'course_qualification' => 1,
            'course_website' => 'https://example.com',
            'course_id' => 1,
            'university_id' => 1,
            'admin_id' => 1
        ];

        $rules = [
            'course_honour_name' => 'required',
            'tuition_fees' => 'required|numeric',
            'credit_hours' => 'required|numeric',
            'duration' => 'required|numeric',
            'minimum_grade' => 'required|numeric|max:4.0',
            'english_requirement_skill' => 'required|numeric|min:1.0|max:5.0',
            'course_qualification' => 'required',
            'course_website' => 'required|url',
            'course_id' => 'required',
            'university_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function validation_fails_with_missing_required_data()
    {
        $data = [];
        $rules = [
            'course_honour_name' => 'required',
            'tuition_fees' => 'required|numeric',
            'credit_hours' => 'required|numeric',
            'duration' => 'required|numeric',
            'minimum_grade' => 'required|numeric|max:4.0',
            'english_requirement_skill' => 'required|numeric|min:1.0|max:5.0',
            'course_qualification' => 'required',
            'course_website' => 'required|url',
            'course_id' => 'required',
            'university_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
    }

     /** @test */
    public function validation_fails_with_invalid_numeric_and_url_values()
    {
        $data = [
            'course_honour_name' => 'Bachelor of Testing',
            'tuition_fees' => -100,                // negative fee invalid
            'credit_hours' => 0,                   // should be positive
            'duration' => -2,                       // negative duration invalid
            'minimum_grade' => 5.0,                 // max is 4.0
            'english_requirement_skill' => 6.0,    // max is 5.0
            'course_qualification' => '',          // required
            'course_website' => 'invalid-url',     // invalid URL
            'course_id' => '',                      // required
            'university_id' => '',                  // required
            'admin_id' => ''                        // required
        ];

        $rules = [
            'course_honour_name' => 'required',
            'tuition_fees' => 'required|numeric|min:0',
            'credit_hours' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:0.1',
            'minimum_grade' => 'required|numeric|max:4.0',
            'english_requirement_skill' => 'required|numeric|min:1.0|max:5.0',
            'course_qualification' => 'required',
            'course_website' => 'required|url',
            'course_id' => 'required',
            'university_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());

        // Check specific errors
        $this->assertArrayHasKey('tuition_fees', $validator->errors()->messages());
        $this->assertArrayHasKey('credit_hours', $validator->errors()->messages());
        $this->assertArrayHasKey('duration', $validator->errors()->messages());
        $this->assertArrayHasKey('minimum_grade', $validator->errors()->messages());
        $this->assertArrayHasKey('english_requirement_skill', $validator->errors()->messages());
        $this->assertArrayHasKey('course_website', $validator->errors()->messages());
        $this->assertArrayHasKey('course_qualification', $validator->errors()->messages());
        $this->assertArrayHasKey('course_id', $validator->errors()->messages());
    }
}
