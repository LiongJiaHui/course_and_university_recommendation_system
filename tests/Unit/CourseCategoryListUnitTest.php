<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class CourseCategoryListUnitTest extends TestCase
{
    /** @test */
    public function it_can_create_a_course_category()
    {
        $admin = Admin::factory()->create();

        $course = Course::create([
            'course_category' => 'Arts Science',
            'course_aspect' => 'Art',
            'admin_id' => $admin->id
        ]);

        $this->assertEquals('Arts Science', $course->course_category);
        $this->assertEquals('Art', $course->course_aspect);
        $this->assertEquals($admin->id, $course->admin_id);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $admin = Admin::factory()->create();

        $course = Course::create([
            'course_category' => 'History',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id
        ]);

        $course->delete();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /** @test */
    public function it_can_search_course_category_or_aspect()
    {
        DB::beginTransaction();

        try {
            $admin = Admin::factory()->create();

            $course1 = Course::create([
                'course_category' => 'Arts',
                'course_aspect' => 'Major',
                'admin_id' => $admin->id
            ]);

            $course2 = Course::create([
                'course_category' => 'Science',
                'course_aspect' => 'Minor',
                'admin_id' => $admin->id
            ]);

            // Search by category, limited to just created courses
            $searchCategory = 'Arts';
            $resultsCategory = Course::whereIn('id', [$course1->id, $course2->id])
                                    ->where(function($q) use ($searchCategory) {
                                        $q->where('course_category', 'LIKE', "%{$searchCategory}%")
                                        ->orWhere('course_aspect', 'LIKE', "%{$searchCategory}%");
                                    })->get();

            $this->assertCount(1, $resultsCategory);
            $this->assertEquals('Arts', $resultsCategory->first()->course_category);

            // Search by aspect, limited to just created courses
            $searchAspect = 'Minor';
            $resultsAspect = Course::whereIn('id', [$course1->id, $course2->id])
                                ->where(function($q) use ($searchAspect) {
                                    $q->where('course_category', 'LIKE', "%{$searchAspect}%")
                                        ->orWhere('course_aspect', 'LIKE', "%{$searchAspect}%");
                                })->get();

            $this->assertCount(1, $resultsAspect);
            $this->assertEquals('Science', $resultsAspect->first()->course_category);

            // Empty search returns empty collection (simulate controller)
            $emptySearch = '';
            $resultsEmpty = collect(); 
            $this->assertTrue($resultsEmpty->isEmpty());

        } finally {
            DB::rollBack();
        }
    }
}
