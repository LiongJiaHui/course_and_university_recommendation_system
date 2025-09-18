<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Course;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Mockery;
use Illuminate\Support\Facades\Validator;

class CourseCategoryUpdateUnitTest extends TestCase
{
    /** @test */
    public function validation_fails_when_required_fields_are_missing()
    {
        $data = [
            'course_category' => '',
            'course_aspect' => '',
            'admin_id' => '',
        ];

        $rules = [
            'course_category' => 'required|string',
            'course_aspect' => 'required|string',
            'admin_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('course_category', $validator->errors()->messages());
        $this->assertArrayHasKey('course_aspect', $validator->errors()->messages());
        $this->assertArrayHasKey('admin_id', $validator->errors()->messages());
    }

    /** @test */
    public function validation_passes_with_valid_data()
    {
        $data = [
            'course_category' => 'Valid Category',
            'course_aspect' => 'Engineering',
            'admin_id' => 1,
        ];

        $rules = [
            'course_category' => 'required|string',
            'course_aspect' => 'required|string',
            'admin_id' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails());
    }
}
