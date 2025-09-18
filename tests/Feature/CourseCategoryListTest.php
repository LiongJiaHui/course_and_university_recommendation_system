<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class CourseCategoryListTest extends TestCase
{
     /** @test */
    public function it_can_search_by_course_category()
    {
        DB::beginTransaction(); // start transaction

        try {
            $admin = Admin::factory()->create();

            Course::create([
                'course_category' => 'Engineering',
                'course_aspect' => 'Major',
                'admin_id' => $admin->id
            ]);

            Course::create([
                'course_category' => 'Business',
                'course_aspect' => 'Minor',
                'admin_id' => $admin->id
            ]);

            $response = $this->get(route('coursecategory.list', ['search' => 'Eng']));

            $response->assertStatus(200);
            $response->assertSee('Engineering');
            $response->assertDontSee('Business');

        } finally {
            DB::rollBack(); // undo changes after test
        }
    }

    /** @test */
    public function it_can_search_by_course_aspect()
    {
        DB::beginTransaction();

        try {
            $admin = Admin::factory()->create();

            Course::create([
                'course_category' => 'Mathematics',
                'course_aspect' => 'Major',
                'admin_id' => $admin->id
            ]);

            Course::create([
                'course_category' => 'Physics',
                'course_aspect' => 'Minor',
                'admin_id' => $admin->id
            ]);

            $response = $this->get(route('coursecategory.list', ['search' => 'Minor']));

            $response->assertStatus(200);
            $response->assertSee('Physics');
            $response->assertDontSee('Mathematics');

        } finally {
            DB::rollBack();
        }
    }

    /** @test */
    public function it_returns_no_results_for_non_matching_search()
    {
        DB::beginTransaction();

        try {
            $admin = Admin::factory()->create();

            Course::create([
                'course_category' => 'History',
                'course_aspect' => 'Major',
                'admin_id' => $admin->id
            ]);

            $response = $this->get(route('coursecategory.list', ['search' => 'Biology']));

            $response->assertStatus(200);
            $response->assertDontSee('History');

        } finally {
            DB::rollBack();
        }
    }

    /** @test */
    public function destroy_deletes_a_course_category()
    {
        $admin = Admin::factory()->create();

        $category = Course::create([
            'course_category' => 'Mathematics',
            'course_aspect' => 'Major',
            'admin_id' => $admin->id
        ]);

        $response = $this->delete(route('coursecategory.destroy', $category->id));

        $response->assertRedirect(route('coursecategory.list'));
        $this->assertDatabaseMissing('courses', ['id' => $category->id]);
    }
}
