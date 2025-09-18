<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;
use App\Models\Course;

class CourseCategoryCreationUnitTest extends TestCase
{
    /** @test */
    public function course_category_can_be_created_via_model()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $course = Course::create([
            'course_category' => 'Test Category',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id,
        ]);

        $this->assertDatabaseHas('courses', [
            'course_category' => 'Test Category',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id
        ]);

        // Clean up
        $course->delete();
    }

    /** @test */
    public function it_throws_validation_exception_when_fields_are_missing()
    {
        $this->expectException(ValidationException::class);

        $admin = Admin::first() ?? Admin::factory()->create();

        $request = Request::create('/coursecategory/store', 'POST', [
            // all fields missing
        ]);

        // Simulate session
        $request->setLaravelSession(session()->put('admin_id', $admin->id));
        $request->setLaravelSession(session()->put('admin_name', $admin->admin_name));

        $controller = new CourseController();
        $controller->store($request);
    }

    /** @test */
    public function it_passes_validation_when_all_fields_are_present()
    {
        $admin = Admin::first() ?? Admin::factory()->create();

        $request = Request::create('/coursecategory/store', 'POST', [
            'course_category' => 'Test Category',
            'course_aspect' => 'Engineering',
            'admin_id' => $admin->id,
        ]);

        $request->setLaravelSession(session()->put('admin_id', $admin->id));
        $request->setLaravelSession(session()->put('admin_name', $admin->admin_name));

        $controller = new CourseController();

        // If validation passes, no exception is thrown
        try {
            $controller->store($request);
            $this->assertTrue(true); // validation passed
        } catch (ValidationException $e) {
            $this->fail('Validation failed unexpectedly.');
        }

        // Clean up manually
        Course::where('course_category', 'Test Category')->delete();
    }
}
