<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CourseDetail;
use Illuminate\Foundation\Testing\WithFaker;

class CourseListTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function course_list_page_loads_and_displays_courses()
    {
        $course = CourseDetail::first(); // Use existing data

        $response = $this->get(route('course.list'));

        $response->assertStatus(200);
        $response->assertSee('Course List');
        $response->assertSee($course->course_honour_name);
        $response->assertSee('New Course');
        $response->assertSee('Detail');
        $response->assertSee('Update');
        $response->assertSee('Delete');
    }

    /** @test */
    public function search_by_course_name_returns_expected_result()
    {
        $course = CourseDetail::first();

        $response = $this->get(route('course.list', ['search' => $course->course_honour_name]));
        $response->assertStatus(200);
        $response->assertSee($course->course_honour_name);
    }

    /** @test */
    public function search_by_university_id_returns_expected_result()
    {
        $course = CourseDetail::first();

        $response = $this->get(route('course.list', ['search' => $course->university_id]));
        $response->assertStatus(200);
        $response->assertSee($course->course_honour_name);
    }

    /** @test */
    public function search_by_admin_id_returns_expected_result()
    {
        $course = CourseDetail::first();

        $response = $this->get(route('course.list', ['search' => $course->admin_id]));
        $response->assertStatus(200);
        $response->assertSee($course->course_honour_name);
    }

    /** @test */
    public function search_with_no_matching_results_displays_empty_message()
    {
        // Use a string that definitely does not exist
        $search = 'NoCourseMatchesThis123';

        $response = $this->get(route('course.list', ['search' => $search]));

        $response->assertStatus(200);

        // Only assert that the "No courses found" message is visible
        $response->assertSee('No courses found');
    }

    /** @test */
    public function search_with_invalid_input_does_not_crash()
    {
        // Search with unexpected input, like a symbol
        $search = '!@#$%^&*()';

        $response = $this->get(route('course.list', ['search' => $search]));

        $response->assertStatus(200);
        $response->assertSee('Course List'); // Page still loads
    }

    /** @test */
    public function course_can_be_deleted_safely()
    {
        // Create a temporary course for deletion test
         $tempCourse = CourseDetail::create([
            'course_honour_name' => 'Temp Test Course',
            'tuition_fees' => 10000,
            'credit_hours' => 120,
            'duration' => 4,
            'minimum_grade' => 3.0,
            'specific_subjects' => '',      
            'merit_mark' => 0,              
            'english_requirement_skill' => 4.0,
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

        $response = $this->delete(route('course.destroy', $tempCourse->id));
        $response->assertRedirect(route('course.list'));
        $response->assertSessionHas('success', 'Course deleted successfully.');

        $this->assertDatabaseMissing('coursedetails', [
            'id' => $tempCourse->id,
        ]);
    }

    /** @test */
    public function deleting_nonexistent_course_returns_404()
    {
        $nonexistentId = 999999; // ID that does not exist

        $response = $this->delete(route('course.destroy', $nonexistentId));
        $response->assertStatus(404);
    }
}
