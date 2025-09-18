<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Area;
use App\Models\State;
use App\Models\Admin;
use App\Models\University;

class UniversityCreationTest extends TestCase
{
    /** @test */
    public function it_fails_when_area_and_postcode_do_not_match()
    {
        $response = $this->post(route('university.store'), [
            'uni_name' => 'Failing University',
            'uni_address' => '123 Nowhere',
            'postcode' => '99999',
            'area' => 'Fake Area',
            'state_id' => 1,
            'campus' => 'Test Campus',
            'website' => 'https://fail.com',
            'uni_type' => 'Private',
            'contact_no' => '609-1234567',
            'email' => 'fail@test.com',
            'admin_id' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['area_id']);
    }

    /** @test */
    public function it_creates_a_university_when_data_is_valid()
    {
        // Ensure dependencies exist (no refresh, so only runs if missing)
        $state = State::firstOrCreate(['id' => 1], ['state_name' => 'Test State']);
        $area = Area::firstOrCreate(
            ['area_name' => 'Kuala Lumpur', 'postcode' => '50300'],
            ['state_id' => $state->id]
        );
        $admin = Admin::firstOrCreate(
            ['admin_name' => 'Admin Test'],
            ['password' => bcrypt('password123')]
        );

        $response = $this->post(route('university.store'), [
            'uni_name' => 'Passing University',
            'uni_address' => '123 Valid Street',
            'postcode' => '50300',
            'area' => 'Kuala Lumpur',
            'state_id' => $state->id,
            'campus' => 'Main Campus',
            'website' => 'https://valid.com',
            'uni_type' => 'Public',
            'contact_no' => '609-1234567',
            'email' => 'valid@test.com',
            'admin_id' => $admin->id,
            // add nullable fields so array keys exist
            'ranking_qs_no_start' => null,
            'ranking_qs_no_end' => null,
            'ranking_qs_year' => null,
            'ranking_the_no_start' => null,
            'ranking_the_no_end' => null,
            'ranking_the_year' => null,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('university.list'));

        $this->assertTrue(University::where('uni_name', 'Passing University')->exists());
    }
}
