<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CourseDetailController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class CourseUpdateUnitTest extends TestCase
{
    /** @test */
    public function update_throws_validation_exception_for_missing_required_fields()
    {
        $this->expectException(ValidationException::class);

        // Mock a request with missing or invalid data
        $request = Request::create('/course/1', 'PUT', [
            'course_honour_name' => '', // required field missing
            'tuition_fees' => -100,     // invalid numeric
            'credit_hours' => 0,        // invalid
            'duration' => 0,
            'minimum_grade' => 5,       // max is 4.0
            'english_requirement_skill' => 6, // max is 5.0
            'course_qualification' => 2, // must be 0 or 1
            'course_website' => 'invalid-url',
            'course_id' => null,
            'university_id' => null,
            'admin_id' => null
        ]);

        // Call the controller
        $controller = new CourseDetailController();
        $controller->update($request, 1);
    }

    /** @test */
    public function update_allows_valid_data_without_throwing_validation_exception()
    {
        // Create a fake request with valid data
        $request = Request::create('/course/1', 'PUT', [
            'course_honour_name' => 'Valid Course',
            'tuition_fees' => 5000,
            'credit_hours' => 120,
            'duration' => 4,
            'minimum_grade' => 3.5,
            'specific_subjects' => 'Math',
            'merit_mark' => 90,
            'english_requirement_skill' => 4.0,
            'ranking_qs_no_start_by_subject' => 10,
            'ranking_qs_no_end_by_subject' => 50,
            'ranking_qs_year_by_subject' => 2025,
            'ranking_the_no_start_by_subject' => 20,
            'ranking_the_no_end_by_subject' => 60,
            'ranking_the_year_by_subject' => 2025,
            'course_qualification' => 1,
            'course_website' => 'https://example.com',
            'course_id' => 1,
            'university_id' => 1,
            'admin_id' => 1
        ]);

        $controller = new CourseDetailController();

        // Expect no exception thrown
        try {
            $controller->update($request, 1);
            $this->assertTrue(true); // passed
        } catch (ValidationException $e) {
            $this->fail("ValidationException was thrown unexpectedly.");
        }
    }
}
