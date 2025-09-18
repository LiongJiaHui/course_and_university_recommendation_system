<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PythonController;

class PreferencesTest extends TestCase
{
     /** @test */
    public function student_information_form_submits_and_stores_in_session()
    {
        $response = $this->post(route('studentinformations.submit'), [
            'name' => 'Jane Doe',
            'address' => '123 Jalan Ampang',
            'postcode' => '50450',
            'area' => 'Ampang',
            'state' => 'Wilayah Persekutuan',
        ]);

        $response->assertRedirect('subjectinformations');

        $this->assertEquals(session('student_info.name'), 'Jane Doe');
        $this->assertEquals(session('student_info.address'), '123 Jalan Ampang');
    }

    /** @test */
    public function subject_information_form_submits_and_stores_in_session()
    {
        $payload = [
            'subjectCount' => 4,
            'subject1' => 'Mathematics',
            'subject1marks' => 4,
            'subject2' => 'Physics',
            'subject2marks' => 3.5,
            'subject3' => 'Chemistry',
            'subject3marks' => 3.8,
            'subject4' => 'Biology',
            'subject4marks' => 3.2,
            'MUETmarks' => 4,
            'cocuriculummarks' => 85,
        ];

        $response = $this->post(route('subjectinformations.submit'), $payload);

        $response->assertRedirect('studentpreferences');

        $this->assertEquals(session('subject_info.subjects')[0]['name'], 'Mathematics');
        $this->assertEquals(session('subject_info.subjects')[0]['marks'], 4);
        $this->assertEquals(session('subject_info.MUETmarks'), 4);
        $this->assertEquals(session('subject_info.cocuriculummarks'), 85);
    }

    /** @test */
    public function student_preferences_form_returns_recommendation_data()
    {
        // Fake previous session data
        session([
            'student_info' => [
                'name' => 'Ali Muhammad',
                'address' => 'Setia Sky Residences, Jalan Raja Muda Abdul Aziz',
                'postcode' => '50300',
                'area' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan Kuala Lumpur',
            ],
            'subject_info' => [
                'subjects' => [
                    ['name' => 'Pengajian Am', 'marks' => 3.92],
                    ['name' => 'Mathematics (T)', 'marks' => 3.75],
                    ['name' => 'Chemistry', 'marks' => 4.00],
                    ['name' => 'Physics', 'marks' => 3.64],
                ],
                'MUETmarks' => 4.5,
                'cocuriculummarks' => 99,
            ],
        ]);

        $response = $this->post(route('studentpreferences.submit'), [
            'unitype' => 'public',
            'preference' => [
                'location', 
                'shortest_distance', 
                'area_of_interest', 
                'expected_fees'
            ],
            'location' => ['Pulau Pinang', 'Wilayah Persekutuan Kuala Lumpur'],
            'area_of_interest' => ['Engineering', 'Information Technology'],
            'tuition_fees_start' => 10000,
            'tuition_fees_end' => 90000,
        ]);

        // Directly get the view data
        $data = $response->viewData('data');

        // Check that the data exists
        $this->assertNotEmpty($data, 'Recommendation data was not generated.');

        // Optional: inspect the first few items
        // dd($data);
    }

    // Error Handling test 
    /** @test */
    public function student_preferences_api_failure_returns_empty_data()
    {
        // Session data
        session([
            'student_info' => ['name' => 'Ali Muhammad'],
            'subject_info' => ['subjects' => [['name' => 'Math', 'marks' => 4]]],
        ]);

        // Simulate API failure by faking an exception
        Http::fake([
            'http://127.0.0.1:5000/final_submit' => Http::response([], 500)
        ]);

        $response = $this->post(route('studentpreferences.submit'), [
            'unitype' => 'public',
            'preference' => ['location'],
            'location' => ['Pulau Pinang'],
            'area_of_interest' => ['Engineering'],
            'tuition_fees_start' => 10000,
            'tuition_fees_end' => 90000,
        ]);

        $data = $response->viewData('data');

        // Should return empty data when API fails
        $this->assertEmpty($data, 'Data should be empty when API fails.');
    }

    /** @test */
    public function student_preferences_api_returns_invalid_data()
    {
        // Prepare session
        session([
            'student_info' => ['name' => 'Ali'],
            'subject_info' => ['subjects' => [], 'MUETmarks' => 4, 'cocuriculummarks' => 90]
        ]);

        // Fake HTTP returning invalid JSON
        Http::fake([
            '127.0.0.1:5000/final_submit' => Http::response('INVALID_JSON', 200)
        ]);

        $response = $this->post(route('studentpreferences.submit'), [
            'unitype' => 'public',
            'preference' => ['location'],
            'location' => ['Kuala Lumpur'],
            'area_of_interest' => ['Engineering'],
            'tuition_fees_start' => 10000,
            'tuition_fees_end' => 90000,
        ]);

        // Now it should be a view with empty data
        $data = $response->viewData('data');

        $this->assertIsArray($data, 'Data should always be an array, even if invalid.');
        $this->assertEmpty($data, 'Data should be empty if API returns invalid structure.');
    }

    /** @test */
    public function student_preferences_fails_without_session_data()
    {
        // Do NOT set session
        $response = $this->post(route('studentpreferences.submit'), [
            'unitype' => 'public',
            'preference' => ['location'],
            'location' => ['Pulau Pinang'],
            'area_of_interest' => ['Engineering'],
            'tuition_fees_start' => 10000,
            'tuition_fees_end' => 90000,
        ]);

        // Controller should handle missing session gracefully
        $data = $response->viewData('data');

        $this->assertEmpty($data, 'Data should be empty if session info is missing.');
    }
}
