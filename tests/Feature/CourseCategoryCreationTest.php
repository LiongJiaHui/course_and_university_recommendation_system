<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Course;
use Illuminate\Foundation\Testing\WithFaker;

class CourseCategoryCreationTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function create_page_loads_correctly()
    {
        $response = $this->get(route('coursecategory.create'));
        $response->assertStatus(200);
        $response->assertSee('Create the Course Category');
        $response->assertSee('Course Category:');
        $response->assertSee('Course Aspect:');
    }

    /** @test */
    public function course_category_can_be_created()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $this->withSession([
            'admin_id' => $admin->id,
            'admin_name' => $admin->admin_name
        ]);

        $data = [
            'course_category' => $this->faker->word,
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id,
        ];

        $response = $this->post(route('coursecategory.store'), $data);

        $response->assertRedirect(route('coursecategory.list'));
        $this->assertDatabaseHas('courses', $data);

        // Clean up
        Course::where('course_category', $data['course_category'])->delete();
    }

    /** @test */
    public function validation_fails_if_fields_are_missing()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $this->withSession([
            'admin_id' => $admin->id,
            'admin_name' => $admin->admin_name
        ]);

        $response = $this->post(route('coursecategory.store'), []);

        $response->assertSessionHasErrors(['course_category', 'course_aspect', 'admin_id']);
    }

    /** @test */
    public function it_fails_if_all_fields_are_missing()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        // Simulate admin session
        $this->withSession([
            'admin_id' => $admin->id,
            'admin_name' => $admin->admin_name
        ]);

        $response = $this->post(route('coursecategory.store'), []);

        // It should redirect back to the form
        $response->assertStatus(302);

        // It should have validation errors
        $response->assertSessionHasErrors(['course_category', 'course_aspect', 'admin_id']);
    }

    /** @test */
    public function it_fails_if_course_category_is_empty()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $this->withSession([
            'admin_id' => $admin->id,
            'admin_name' => $admin->admin_name
        ]);

        $response = $this->post(route('coursecategory.store'), [
            'course_category' => '',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id,
        ]);

        $response->assertSessionHasErrors(['course_category']);
    }

    /** @test */
    public function it_fails_if_course_aspect_is_empty()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $this->withSession([
            'admin_id' => $admin->id,
            'admin_name' => $admin->admin_name
        ]);

        $response = $this->post(route('coursecategory.store'), [
            'course_category' => 'Test Category',
            'course_aspect' => '',
            'admin_id' => $admin->id,
        ]);

        $response->assertSessionHasErrors(['course_aspect']);
    }

    /** @test */
    public function it_fails_if_admin_id_is_missing()
    {
        $response = $this->post(route('coursecategory.store'), [
            'course_category' => 'Test Category',
            'course_aspect' => 'Engineering',
            // admin_id missing
        ]);

        $response->assertSessionHasErrors(['admin_id']);
    }
}
