<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Models\University;

class UniversityListTest extends TestCase
{
    
     /** @test */
    public function it_deletes_a_university_record()
    {
        // Arrange: create a university with full dataset
        $university = University::create([
            'uni_name'              => 'TechVille University',
            'uni_address'           => '123 Innovation Road',
            'postcode'              => '50000',
            'area_id'                  => 1,
            'state_id'              => 1, // must exist in states
            'campus'                => 'Main Campus',
            'website'               => 'https://www.techville.edu',
            'uni_type'              => 'Private',
            'contact_no'            => '03-12345678',
            'email'                 => 'info@techville.edu',
            'ranking_qs_no_start'   => 200,
            'ranking_qs_no_end'     => 210,
            'ranking_qs_year'       => 2025,
            'ranking_the_no_start'  => 180,
            'ranking_the_no_end'    => 190,
            'ranking_the_year'      => 2025,
            'admin_id'              => 1, // must exist in admins
        ]);

        // Act: delete the record
        University::destroy($university->id);

        // Assert: record is gone
        $this->assertDatabaseMissing('universities', [
            'id' => $university->id,
        ]);
    }
    
    /** @test */
    public function it_can_search_universities_by_name()
    {
        $response = $this->get('/University?search=Universiti Malaya');
        $response->assertStatus(200);
        $response->assertSee('Universiti Malaya'); 
    }

    /** @test */
    public function it_can_search_universities_by_campus()
    {
        $response = $this->get('/University?search=Main Campus');
        $response->assertStatus(200);
        $response->assertSee('Main Campus'); 
    }

    /** @test */
    public function it_can_search_universities_by_website()
    {
        $response = $this->get('/University?search=https://www.utm.my');
        $response->assertStatus(200);
        $response->assertSee('https://www.utm.my'); // ensures campus London is shown
    }

    /** @test */
    public function it_can_search_universities_by_type()
    {
        $response = $this->get('/University?search=Public');
        $response->assertStatus(200);
        $response->assertSee('Public'); // ensures campus London is shown
    }


    /** @test */
    public function it_can_sort_universities_by_qs_ranking()
    {
        $response = $this->get('/University?sort=qs');
        $response->assertStatus(200);

        $universities = University::orderByRaw('ISNULL(ranking_qs_no_start), ranking_qs_no_start ASC')
            ->pluck('uni_name')
            ->toArray();

        if (count($universities) >= 2) {
            $first = strpos($response->getContent(), $universities[0]);
            $second = strpos($response->getContent(), $universities[1]);
            $this->assertTrue($first < $second, "QS sorting order is incorrect.");
        }
    }

    /** @test */
    public function it_can_sort_universities_by_the_ranking()
    {
        $response = $this->get('/University?sort=the');
        $response->assertStatus(200);

        $universities = University::orderByRaw('ISNULL(ranking_the_no_start), ranking_the_no_start ASC')
            ->pluck('uni_name')
            ->toArray();

        if (count($universities) >= 2) {
            $first = strpos($response->getContent(), $universities[0]);
            $second = strpos($response->getContent(), $universities[1]);
            $this->assertTrue($first < $second, "THE sorting order is incorrect.");
        }
    }

    // Error Handling Tests
     /** @test */
    public function it_returns_no_results_message_when_university_not_found()
    {
        $response = $this->get('/University?search=ThisUniversityDoesNotExistXYZ');
        $response->assertStatus(200);
        $response->assertSee('No universities found');
    }

    /** @test */
    public function it_handles_invalid_sort_parameter_gracefully()
    {
        $response = $this->get('/University?sort=invalid');
        $response->assertStatus(200);
        $response->assertSee('University List'); // Page should still render normally
    }

    /** @test */
    public function it_displays_full_list_when_search_query_is_empty()
    {
        $response = $this->get('/University?search=');
        $response->assertStatus(200);

        // Pick any known university from DB
        $this->assertStringContainsString(
            'Universiti Malaya',
            $response->getContent(),
            'Expected full list of universities when search is empty.'
        );
    }

    /** @test */
    public function it_handles_null_rankings_in_sorting()
    {
        // Force one university to have null ranking
        University::where('uni_name', 'Universiti Malaya')
            ->update(['ranking_qs_no_start' => null]);

        $response = $this->get('/University?sort=qs');
        $response->assertStatus(200);
        $response->assertSee('University List'); // Page should still load fine
    }
}
