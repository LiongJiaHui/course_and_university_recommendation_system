<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CourseDetailController;
use App\Models\CourseDetail;
use Illuminate\Http\Request;

class CourseListUnitTest extends TestCase
{
    /** @test */
    public function index_returns_courses()
    {
        $controller = new CourseDetailController();

        // Create dummy course
        $course = CourseDetail::first();

        $request = Request::create('/dummy', 'GET');

        $response = $controller->index($request);

        // Check that view is returned
        $this->assertEquals('Administrator.Course.CourseList', $response->getName());

        // Check that courses variable exists and contains our course
        $this->assertTrue($response->getData()['courses']->contains($course));
    }

    /** @test */
    public function index_search_filters_courses()
    {
        $controller = new CourseDetailController();

        $course = CourseDetail::first();
        $searchRequest = Request::create('/dummy?search=' . $course->course_honour_name, 'GET');

        $response = $controller->index($searchRequest);

        // Only matching course should be returned
        $courses = $response->getData()['courses'];
        $this->assertTrue($courses->contains($course));
    }

    /** @test */
    public function destroy_deletes_course()
    {
        $controller = new CourseDetailController();

        // Create temporary course for deletion
        $tempCourse = CourseDetail::create([
            'course_honour_name' => 'Unit Test Course',
            'tuition_fees' => 1000,
            'credit_hours' => 120,
            'duration' => 4,
            'minimum_grade' => 3.0,
            'specific_subjects' => '',
            'merit_mark' => 0,
            'english_requirement_skill' => 4,
            'ranking_qs_no_start_by_subject' => 0,
            'ranking_qs_no_end_by_subject' => 0,
            'ranking_qs_year_by_subject' => 0,
            'ranking_the_no_start_by_subject' => 0,
            'ranking_the_no_end_by_subject' => 0,
            'ranking_the_year_by_subject' => 0,
            'course_qualification' => true,
            'course_website' => 'https://example.com',
            'course_id' => 9999,
            'university_id' => 1,
            'admin_id' => 1,
        ]);

        $response = $controller->destroy($tempCourse->id);

        $this->assertDatabaseMissing('coursedetails', ['id' => $tempCourse->id]);
    }

    /** @test */
    public function index_handles_search_with_no_matches()
    {
        $controller = new CourseDetailController();

        $request = \Illuminate\Http\Request::create('/dummy?search=NoMatch123', 'GET');
        $response = $controller->index($request);

        $courses = $response->getData()['courses'];

        // The courses collection should be empty
        $this->assertTrue($courses->isEmpty());
    }

    /** @test */
    public function index_handles_invalid_search_input_gracefully()
    {
        $controller = new CourseDetailController();

        $request = \Illuminate\Http\Request::create('/dummy?search=!@#$%^', 'GET');
        $response = $controller->index($request);

        $courses = $response->getData()['courses'];

        // The page still returns a collection (may be empty)
        $this->assertIsIterable($courses);
    }

    /** @test */
    public function destroy_throws_exception_for_nonexistent_course()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $controller = new CourseDetailController();

        // Attempt to delete a course ID that doesn't exist
        $controller->destroy(999999);
    }
}
