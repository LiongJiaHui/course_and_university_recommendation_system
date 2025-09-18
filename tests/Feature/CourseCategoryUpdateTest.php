<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Admin;

class CourseCategoryUpdateTest extends TestCase
{
     /** @test */
    public function edit_page_displays_correctly()
    {
        $category = Course::first();  // Existing category
        $response = $this->get(route('coursecategory.edit', $category->id));

        $response->assertStatus(200);
        $response->assertSee('Update Course Category');
        $response->assertSee($category->course_category);
    }

    /** @test */
    public function course_category_can_be_updated_successfully()
    {
        $category = Course::first();
        $admin = Admin::first();

        $response = $this->put(route('coursecategory.update', $category->id), [
            'course_category' => 'Updated Category',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id,
        ]);

        $response->assertRedirect(route('coursecategory.list'));
        $response->assertSessionHas('success', 'Course Category updated successfully.');

        $category->refresh();
        $this->assertEquals('Updated Category', $category->course_category);
        $this->assertEquals('Engineering', $category->course_aspect);
        $this->assertEquals($admin->id, $category->admin_id);
    }

    /** @test */
    public function update_fails_when_required_fields_are_missing()
    {
        $category = Course::first();

        $response = $this->from(route('coursecategory.edit', $category->id))
                         ->put(route('coursecategory.update', $category->id), [
                             'course_category' => '',
                             'course_aspect' => '',
                             'admin_id' => '',
                         ]);

        $response->assertRedirect(route('coursecategory.edit', $category->id));
        $response->assertSessionHasErrors(['course_category', 'course_aspect', 'admin_id']);
    }
}
