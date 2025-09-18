<?php

namespace Tests\Unit;

use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PythonController;

class SubjectInfoUnitTest extends TestCase
{
     /** @test */
    public function it_accepts_valid_input_with_4_subjects()
    {
        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $response = $controller->storeSubjectInfo($request);

        $this->assertEquals(302, $response->getStatusCode()); // redirect
        $sessionData = session('subject_info');
        $this->assertCount(4, $sessionData['subjects']);
    }

    /** @test */
    public function it_accepts_valid_input_with_5_subjects()
    {
        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 5,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'subject5' => 'Biology',
            'subject5marks' => '3.20',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '9',
        ]);

        $controller = new PythonController();
        $response = $controller->storeSubjectInfo($request);

        $this->assertEquals(302, $response->getStatusCode()); // redirect
        $sessionData = session('subject_info');
        $this->assertCount(5, $sessionData['subjects']);
        $this->assertEquals('Biology', $sessionData['subjects'][4]['name']);
    }

    // Error Handling Tests

     /** @test */
    public function it_throws_validation_if_subject_mark_is_not_numeric()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => 'abc', // ❌ not numeric
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_subject_mark_is_out_of_range()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '5.00', // ❌ exceeds max
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_cocuriculummarks_is_out_of_range()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '200', // ❌ invalid
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_subjectcount_is_invalid()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 2, // ❌ too few
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_subject_name_is_empty_string()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => '', // ❌ empty string
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }
    
    /** @test */
    public function it_throws_validation_exception_if_subject_name_is_missing()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            // Missing subject1name
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_exception_if_subject_mark_is_missing()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            // Missing subject1marks
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_exception_if_muet_is_out_of_range()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '7.0', // ❌ invalid
            'cocuriculummarks' => '8',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_exception_if_cocuriculummarks_is_missing()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'MUETmarks' => '4.0',
            // ❌ cocuriculummarks missing
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_subjectcount_is_5_but_only_4_subjects_given()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 5,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            // ❌ subject5 missing
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '9',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

    /** @test */
    public function it_throws_validation_if_subjectcount_is_4_but_5_subjects_given()
    {
        $this->expectException(ValidationException::class);

        $request = Request::create('/subjectinformations', 'POST', [
            'subjectCount' => 4,
            'subject1' => 'Pengajian Am',
            'subject1marks' => '3.50',
            'subject2' => 'Mathematics',
            'subject2marks' => '3.00',
            'subject3' => 'Physics',
            'subject3marks' => '2.50',
            'subject4' => 'Chemistry',
            'subject4marks' => '2.00',
            'subject5' => 'Biology', // ❌ extra subject
            'subject5marks' => '3.20',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '9',
        ]);

        $controller = new PythonController();
        $controller->storeSubjectInfo($request);
    }

}
