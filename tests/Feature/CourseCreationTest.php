<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\University;
use App\Models\Course;
use App\Models\CourseDetail;

class CourseCreationTest extends TestCase
{
    /** @test */
    public function course_create_page_loads_successfully()
    {
        $response = $this->get(route('course.create'));

        $response->assertStatus(200);
        $response->assertSee('Creation of the Course');
        $response->assertSee('Course Honour Name');
    }

    /** @test */
    public function course_can_be_created_successfully()
    {
        // Create required related models manually
        $admin = Admin::first() ?? Admin::factory()->create();
        $university = University::first() ?? University::factory()->create();
        $category = Course::first() ?? Course::factory()->create();

        $data = [
            'course_honour_name' => 'Bachelor of Testing',
            'tuition_fees' => 10000,
            'credit_hours' => 12,
            'duration' => 3,
            'minimum_grade' => 3.0,
            'specific_subjects' => 'Math, Physics',
            'merit_mark' => 80,
            'english_requirement_skill' => 4.0,
            'ranking_qs_no_start_by_subject' => 1,
            'ranking_qs_no_end_by_subject' => 50,
            'ranking_qs_year_by_subject' => 2025,
            'ranking_the_no_start_by_subject' => 1,
            'ranking_the_no_end_by_subject' => 100,
            'ranking_the_year_by_subject' => 2025,
            'course_qualification' => true,
            'course_website' => 'https://example.com',
            'course_id' => $category->id,
            'university_id' => $university->id,
            'admin_id' => $admin->id,
        ];

        $response = $this->post(route('course.store'), $data);

        $response->assertRedirect(route('course.list'));
        $this->assertDatabaseHas('coursedetails', [
            'course_honour_name' => 'Bachelor of Testing',
        ]);

        // Clean up to avoid polluting DB
        CourseDetail::where('course_honour_name', 'Bachelor of Testing')->delete();
    }

    /** @test */
    public function course_creation_fails_with_missing_required_fields()
    {
        $response = $this->post(route('course.store'), []);

        $response->assertSessionHasErrors([
            'course_honour_name',
            'tuition_fees',
            'credit_hours',
            'duration',
            'minimum_grade',
            'english_requirement_skill',
            'course_qualification',
            'course_website',
            'course_id',
            'university_id',
            'admin_id'
        ]);
    }

    /** @test */
    public function it_shows_errors_when_required_fields_are_missing()
    {
        $response = $this->post(route('course.store'), []); // submit empty form

        $response->assertRedirect(); // should redirect back
        $response->assertSessionHasErrors([
            'course_honour_name',
            'tuition_fees',
            'credit_hours',
            'duration',
            'minimum_grade',
            'english_requirement_skill',
            'course_qualification',
            'course_website',
            'course_id',
            'university_id',
            'admin_id',
        ]);
    }

    /** @test */
    public function it_shows_errors_when_numeric_fields_have_invalid_values()
    {
        // Create required related models manually
        $admin = Admin::first() ?? Admin::factory()->create();
        $university = University::first() ?? University::factory()->create();
        $category = Course::first() ?? Course::factory()->create();

        $data = [
            'course_honour_name' => '',                   // required
            'tuition_fees' => -100,                       // invalid
            'credit_hours' => -1,                          // invalid
            'duration' => -1,                             // invalid
            'minimum_grade' => 5.0,                       // max is 4.0
            'english_requirement_skill' => 6.0,           // max is 5.0
            'course_qualification' => '',                 // required
            'course_website' => 'not-a-url',             // invalid URL
            'course_id' => '',                             // required
            'university_id' => '',                         // required
            'admin_id' => '',                              // required
        ];

        $response = $this->post(route('course.store'), $data);

        $response->assertRedirect(); // redirected back to form
        $response->assertSessionHasErrors([
            'course_honour_name',
            'tuition_fees',
            'credit_hours',
            'duration',
            'minimum_grade',
            'english_requirement_skill',
            'course_qualification',
            'course_website',
            'course_id',
            'university_id',
            'admin_id',
        ]);
    }

    /** @test */
    public function old_input_is_retained_on_validation_error()
    {
        $response = $this->post(route('course.store'), [
            'course_honour_name' => 'Test Course',
            'tuition_fees' => -100, // invalid
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('tuition_fees');
        $this->assertTrue(session()->hasOldInput('course_honour_name'));
    }
}
