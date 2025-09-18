<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\CourseDetail;
use App\Models\University;
use App\Models\Admin;
use App\Models\Course;
use Illuminate\Foundation\Testing\WithFaker;

class CourseUpdateTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function edit_page_displays_correctly()
    {
        // Arrange: make sure related models exist
        $university = University::first() ?? University::factory()->create();
        $admin = Admin::first() ?? Admin::factory()->create();
        $category = Course::first() ?? Course::factory()->create(['admin_id' => $admin->id]);
        $course = CourseDetail::factory()->create([
            'university_id' => $university->id,
            'admin_id' => $admin->id,
            'course_id' => $category->id,
        ]);

        // Act
        $response = $this->get(route('course.edit', $course->id));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Update the Course');
        $response->assertSee($course->course_honour_name);
    }

    /** @test */
    public function update_course_successfully()
    {
        $university = University::first() ?? University::factory()->create();
        $admin = Admin::first() ?? Admin::factory()->create();
        $category = Course::first() ?? Course::factory()->create(['admin_id' => $admin->id]);
        $course = CourseDetail::factory()->create([
            'university_id' => $university->id,
            'admin_id' => $admin->id,
            'course_id' => $category->id,
        ]);

        $updateData = [
            'course_honour_name' => 'Updated Course',
            'tuition_fees' => 6000,
            'credit_hours' => 120,
            'duration' => 4,
            'minimum_grade' => 3.5,
            'specific_subjects' => 'Math, Physics',
            'merit_mark' => 90,
            'english_requirement_skill' => 4.0,
            'ranking_qs_no_start_by_subject' => 10,
            'ranking_qs_no_end_by_subject' => 50,
            'ranking_qs_year_by_subject' => 2025,
            'ranking_the_no_start_by_subject' => 20,
            'ranking_the_no_end_by_subject' => 60,
            'ranking_the_year_by_subject' => 2025,
            'course_qualification' => true,
            'course_website' => 'https://example.com',
            'course_id' => $category->id,
            'university_id' => $university->id,
            'admin_id' => $admin->id,
        ];

        $response = $this->put(route('course.update', $course->id), $updateData);

        $response->assertRedirect(route('course.list'));
        $response->assertSessionHas('success', 'Course updated successfully.');

        $this->assertDatabaseHas('coursedetails', [
            'id' => $course->id,
            'course_honour_name' => 'Updated Course',
            'tuition_fees' => 6000,
        ]);
    }

    /** @test */
    public function update_course_fails_validation_for_missing_required_fields()
    {
        $course = CourseDetail::first() ?? CourseDetail::factory()->create();

        $response = $this->put(route('course.update', $course->id), []);

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
}
