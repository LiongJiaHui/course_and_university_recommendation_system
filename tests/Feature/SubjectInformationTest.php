<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubjectInformationTest extends TestCase
{
    // focus on the testing input data section
   /** @test */
    public function subject_information_form_can_store_4_subjects_and_redirect()
    {
        $response = $this->post(route('subjectinformations.submit'), [
            'subjectCount' => '4',
            'subject1' => 'Pengajian Am',
            'subject1marks' => '4.00',
            'subject2' => 'Mathematics (M)',
            'subject2marks' => '3.50',
            'subject3' => 'Biology',
            'subject3marks' => '3.00',
            'subject4' => 'Chemistry',
            'subject4marks' => '3.25',
            'subject5' => '',  // not selected
            'subject5marks' => '',
            'MUETmarks' => '4.5',
            'cocuriculummarks' => '85',
        ]);

        // Redirect to next page
        $response->assertStatus(302);
        $response->assertRedirect('studentpreferences');

        // Check session
        $sessionData = session('subject_info');

        $this->assertCount(4, $sessionData['subjects']);
        $this->assertEquals('Pengajian Am', $sessionData['subjects'][0]['name']);
        $this->assertEquals('4.00', $sessionData['subjects'][0]['marks']);
        $this->assertEquals('4.5', $sessionData['MUETmarks']);
        $this->assertEquals(85, $sessionData['cocuriculummarks']);
    }

    /** @test */
    public function subject_information_form_can_store_5_subjects_and_redirect()
    {
        $response = $this->post(route('subjectinformations.submit'), [
            'subjectCount' => '5',
            'subject1' => 'Pengajian Am',
            'subject1marks' => '4.00',
            'subject2' => 'Mathematics (M)',
            'subject2marks' => '3.50',
            'subject3' => 'Biology',
            'subject3marks' => '3.00',
            'subject4' => 'Chemistry',
            'subject4marks' => '3.25',
            'subject5' => 'Physics',
            'subject5marks' => '3.75',
            'MUETmarks' => '4.0',
            'cocuriculummarks' => '90',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('studentpreferences');

        $sessionData = session('subject_info');
        $this->assertCount(5, $sessionData['subjects']);
        $this->assertEquals('Physics', $sessionData['subjects'][4]['name']);
        $this->assertEquals('3.75', $sessionData['subjects'][4]['marks']);
        $this->assertEquals('4.0', $sessionData['MUETmarks']);
        $this->assertEquals(90, $sessionData['cocuriculummarks']);
    }

    // Error Handling Test

    /** @test */
    public function store_subject_info_validation_errors_are_handled_invalid_marks()
    {
        // Invalid marks and empty required subject
        $response = $this->post(route('subjectinformations.submit'), [
            'subject1' => '',          // required
            'subject1marks' => '',     // required
            'subject2marks' => 5,      // invalid >4
            'MUETmarks' => 6,          // invalid >5
            'cocuriculummarks' => 150, // invalid >100
        ]);

        $response->assertSessionHasErrors([
            'subject1',
            'subject1marks',
            'subject2marks',
            'MUETmarks',
            'cocuriculummarks',
        ]);

        // Ensure invalid data is not stored
        $this->assertNull(session('subject_info'));
    }

    /** @test */
    public function store_subject_info_validation_errors_are_handled_empty_fields()
    {
        // Submit empty form
        $response = $this->post(route('subjectinformations.submit'), [
            'subject1' => '',
            'subject1marks' => '',
            'MUETmarks' => '6',  // invalid >5
            'cocuriculummarks' => 150, // invalid >100
        ]);

        // We are not using DB, so just check session not set correctly
        $this->assertNull(session('subject_info'));
    }
}
