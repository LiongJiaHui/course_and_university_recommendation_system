<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\PythonController;
use Illuminate\Validation\ValidationException;

class StudentInformationUnitTest extends TestCase
{

    /** @test */
    public function it_stores_valid_student_information_in_session()
    {
        $controller = new PythonController();

        $request = Request::create('/studentinformations', 'POST', [
            'name'     => 'John Doe',
            'address'  => '123 Jalan ABC',
            'postcode' => '50450',
            'area'     => 'Ampang',
            'state'    => 'Selangor',
        ]);

        $response = $controller->storeStudentInfo($request);

        $this->assertEquals(url('subjectinformations'), $response->headers->get('Location'));

        $this->assertEquals([
            'name'     => 'John Doe',
            'address'  => '123 Jalan ABC',
            'postcode' => '50450',
            'area'     => 'Ampang',
            'state'    => 'Selangor',
        ], session('student_info'));
    }

    /** @test */
    public function it_throws_validation_exception_when_required_fields_missing()
    {
        $controller = new PythonController();

        $request = Request::create('/studentinformations', 'POST', [
            // intentionally leave fields empty
        ]);

        try {
            $controller->storeStudentInfo($request);
            $this->fail("Expected ValidationException was not thrown.");
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->keys();

            $this->assertContains('name', $errors, "Validation error for 'name' missing.");
            $this->assertContains('address', $errors, "Validation error for 'address' missing.");
            $this->assertContains('postcode', $errors, "Validation error for 'postcode' missing.");
            $this->assertContains('area', $errors, "Validation error for 'area' missing.");
            $this->assertContains('state', $errors, "Validation error for 'state' missing.");
        }
    }
}
