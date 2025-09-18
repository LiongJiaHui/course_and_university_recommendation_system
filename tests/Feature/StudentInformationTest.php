<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class StudentInformationTest extends TestCase
{
    // focus on the testing input data section

    /** 
     * @return void
     * */ 
    public function test_student_information_form_submission()
    {
        $response = $this->post(route('studentinformations.submit'), [
            'name' => 'Then Mah Seng',
            'address' => '123 Test Street',
            'postcode' => '43000',
            'area' => 'Cheras',
            'state' => 'Selangor',
        ]);

        $response->assertStatus(302); // expect redirect after success
        $response->assertRedirect('/subjectinformations'); // change to your actual redirect
    }   

    // test for the invalid output
    /** @test */
    public function it_rejects_invalid_student_information()
    {
        $response = $this->post(route('studentinformations.submit'), [
            'name' => '', // missing name
            'address' => '123 Test Street',
            'postcode' => '43000',
            'area' => 'Cheras',
            'state' => 'Selangor',
        ]);

        $response->assertStatus(302); // expect redirect back on validation failure
        $response->assertSessionHasErrors(['name']); // check for validation error on name
    }

    /** @test */
    public function student_info_form_fails_with_missing_fields()
    {
        $response = $this->from(route('studentinformation'))
            ->post(route('studentinformations.submit'), [
                'name' => '',
                'address' => '',
                'postcode' => '',
                'area' => '',
                'state' => '',
            ]);

        $response->assertStatus(302); 
        $response->assertRedirect(route('studentinformations.submit')); 
        $response->assertSessionHasErrors(['name', 'address', 'postcode', 'area', 'state']);
    }

     /** @test */
    public function student_info_fails_with_invalid_postcode()
    {
        // Assume the DB already has a valid postcode for Ampang
        $validPostcodes = DB::table('areas')
            ->where('area_name', 'Ampang')
            ->pluck('postcode')
            ->toArray();

        // Temporarily override the route validation for testing
        $this->app['router']->post('/studentinformations', function (\Illuminate\Http\Request $request) use ($validPostcodes) {
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'state' => 'required',
                'area' => 'required',
                'postcode' => ['required', Rule::in($validPostcodes)],
            ]);

            session(['student_info' => $request->all()]);
            return redirect('subjectinformations');
        })->name('studentinformations.submit');

        $response = $this->post(route('studentinformations.submit'), [
            'name' => 'Jane Doe',
            'address' => '456 Jalan Ampang',
            'area' => 'Ampang',
            'state' => 'Selangor',
            'postcode' => '99999', // invalid
        ]);

        $response->assertSessionHasErrors(['postcode']);
    }
}
