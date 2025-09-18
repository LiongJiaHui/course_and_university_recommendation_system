<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\University;
use App\Models\Admin;
use App\Models\State;
use App\Models\Area;

class UniversityUpdateTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_validation_errors_if_required_fields_missing()
    {
        $university = University::first();

        $response = $this->put(route('university.update', $university->id), []);

        $response->assertSessionHasErrors([
            'uni_name', 'uni_address', 'postcode', 'area',
            'state_id', 'campus', 'website', 'uni_type',
            'contact_no', 'email', 'admin_id'
        ]);
    }

    /** @test */
    public function it_returns_error_if_area_and_postcode_do_not_match()
    {
        $university = University::first();
        $state = State::first();
        $admin = Admin::first();

        $data = [
            'uni_name' => 'Wrong Area Uni',
            'uni_address' => 'No Match Street',
            'postcode' => '99999',
            'area' => 'Fake Area',
            'state_id' => $state->id,
            'campus' => 'Test Campus',
            'website' => 'https://fake.edu',
            'uni_type' => 'Public',
            'contact_no' => '609-1234567',
            'email' => 'wrong@uni.edu',
            'admin_id' => $admin->id
        ];

        $response = $this->put(route('university.update', $university->id), $data);

        $response->assertSessionHasErrors(['area_id']);
    }

    /** @test */
public function it_updates_university_with_valid_data()
{
    $university = University::latest('id')->first();
    $state = State::first();
    $admin = Admin::first();
    $area = Area::first();

    $data = [
        'uni_name' => 'Boyle, Ankunding and Stoltenberg University',
        'uni_address' => '24923 Wiegand Isle Port Mortimer, CA 15129-5734',
        'postcode' => $area->postcode,
        'area' => $area->area_name,
        'state_id' => $state->id,
        'campus' => 'Clementmouth Campus',
        'website' => 'https://www.oconner.com/aut-quaerat-eos-optio-vero-et-culpa',
        'uni_type' => 'Private',
        'contact_no' => '364.734.3567',
        'email' => 'rasheed.ledner@example.org',
        'admin_id' => $admin->id,
        // keep ranking columns null like your insert
        'ranking_qs_no_start' => null,
        'ranking_qs_no_end' => null,
        'ranking_qs_year' => null,
        'ranking_the_no_start' => null,
        'ranking_the_no_end' => null,
        'ranking_the_year' => null,
    ];

    $response = $this->put(route('university.update', $university->id), $data);

    $response->assertRedirect(route('university.list'));

    $this->assertDatabaseHas('universities', [
        'id' => $university->id,
        'uni_name' => 'Boyle, Ankunding and Stoltenberg University',
        'campus' => 'Clementmouth Campus',
        'uni_type' => 'Private',
        'email' => 'rasheed.ledner@example.org',
        'area_id' => $area->id,
    ]);
}
}
