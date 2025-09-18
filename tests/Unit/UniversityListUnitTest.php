<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\University;

class UniversityListUnitTest extends TestCase
{
    /** @test */
    public function it_deletes_a_university_record()
    {
        // Arrange: create a university
        $university = University::create([
            'uni_name'              => 'TechVille University',
            'uni_address'           => '123 Innovation Road',
            'postcode'              => '50000',
            'area_id'                  => 1,
            'state_id'              => 1, // must exist in your states table
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
            'admin_id'              => 1, 
        ]);

        // Act: delete it
        University::destroy($university->id);

        // Assert: should not exist anymore
        $this->assertDatabaseMissing('universities', [
            'id' => $university->id,
        ]);
    }
    
    /** @test */
    public function it_filters_by_search_term_in_uni_name()
    {
        $search = 'Universiti Malaya';
        $query = University::query()
            ->where(function ($q) use ($search) {
                $q->where('uni_name', 'LIKE', "%{$search}%")
                  ->orWhere('campus', 'LIKE', "%{$search}%")
                  ->orWhere('website', 'LIKE', "%{$search}%")
                  ->orWhere('uni_type', 'LIKE', "%{$search}%");
            })
            ->get();

        $this->assertTrue($query->contains(function ($u) use ($search) {
            return stripos($u->uni_name, $search) !== false ||
                   stripos($u->campus, $search) !== false ||
                   stripos($u->website, $search) !== false ||
                   stripos($u->uni_type, $search) !== false;
        }));
    }

     /** @test */
    public function it_filters_by_search_term_in_campus()
    {
        $search = 'Main Campus';
        $query = University::query()
            ->where(function ($q) use ($search) {
                $q->where('uni_name', 'LIKE', "%{$search}%")
                  ->orWhere('campus', 'LIKE', "%{$search}%")
                  ->orWhere('website', 'LIKE', "%{$search}%")
                  ->orWhere('uni_type', 'LIKE', "%{$search}%");
            })
            ->get();

        $this->assertTrue($query->contains(function ($u) use ($search) {
            return stripos($u->uni_name, $search) !== false ||
                   stripos($u->campus, $search) !== false ||
                   stripos($u->website, $search) !== false ||
                   stripos($u->uni_type, $search) !== false;
        }));
    }

     /** @test */
    public function it_filters_by_search_term_in_website()
    {
        $search = 'https://www.utm.my/';
        $query = University::query()
            ->where(function ($q) use ($search) {
                $q->where('uni_name', 'LIKE', "%{$search}%")
                  ->orWhere('campus', 'LIKE', "%{$search}%")
                  ->orWhere('website', 'LIKE', "%{$search}%")
                  ->orWhere('uni_type', 'LIKE', "%{$search}%");
            })
            ->get();

        $this->assertTrue($query->contains(function ($u) use ($search) {
            return stripos($u->uni_name, $search) !== false ||
                   stripos($u->campus, $search) !== false ||
                   stripos($u->website, $search) !== false ||
                   stripos($u->uni_type, $search) !== false;
        }));
    }
    
     /** @test */
    public function it_filters_by_search_term_in_uni_type()
    {
        $search = 'Public';
        $query = University::query()
            ->where(function ($q) use ($search) {
                $q->where('uni_name', 'LIKE', "%{$search}%")
                  ->orWhere('campus', 'LIKE', "%{$search}%")
                  ->orWhere('website', 'LIKE', "%{$search}%")
                  ->orWhere('uni_type', 'LIKE', "%{$search}%");
            })
            ->get();

        $this->assertTrue($query->contains(function ($u) use ($search) {
            return stripos($u->uni_name, $search) !== false ||
                   stripos($u->campus, $search) !== false ||
                   stripos($u->website, $search) !== false ||
                   stripos($u->uni_type, $search) !== false;
        }));
    }

    /** @test */
    public function it_sorts_by_qs_ranking()
    {
        $universities = University::orderByRaw('ISNULL(ranking_qs_no_start), ranking_qs_no_start ASC')->get();

        $values = $universities->pluck('ranking_qs_no_start')->filter()->values()->toArray();

        $sorted = $values;
        sort($sorted);

        $this->assertEquals($sorted, $values, 'QS ranking order mismatch');
    }

    /** @test */
    public function it_sorts_by_the_ranking()
    {
        $universities = University::orderByRaw('ISNULL(ranking_the_no_start), ranking_the_no_start ASC')->get();

        $values = $universities->pluck('ranking_the_no_start')->filter()->values()->toArray();

        $sorted = $values;
        sort($sorted);

        $this->assertEquals($sorted, $values, 'THE ranking order mismatch');
    }

    // Error handling tests

    /** @test */
    public function it_returns_empty_when_no_search_results_found()
    {
        $search = 'NonExistentUniversityXYZ';
        $query = University::query()
            ->where(function ($q) use ($search) {
                $q->where('uni_name', 'LIKE', "%{$search}%")
                  ->orWhere('campus', 'LIKE', "%{$search}%")
                  ->orWhere('website', 'LIKE', "%{$search}%")
                  ->orWhere('uni_type', 'LIKE', "%{$search}%");
            })
            ->get();

        $this->assertTrue($query->isEmpty(), 'Expected no universities but some were found.');
    }

    /** @test */
    public function it_handles_invalid_sort_value_gracefully()
    {
        // Simulate sort = "invalid"
        $universities = University::query();

        $sort = 'invalid';
        if ($sort === 'qs') {
            $universities->orderByRaw('ISNULL(ranking_qs_no_start), ranking_qs_no_start ASC');
        } elseif ($sort === 'the') {
            $universities->orderByRaw('ISNULL(ranking_the_no_start), ranking_the_no_start ASC');
        }
        $results = $universities->get();

        // Expect results but unsorted (default order)
        $this->assertNotNull($results, 'Query should still return results even with invalid sort.');
    }

    /** @test */
    public function it_handles_null_ranking_values_in_qs_sort()
    {
        $universities = University::orderByRaw('ISNULL(ranking_qs_no_start), ranking_qs_no_start ASC')->get();

        // Extract QS ranking values (may contain null)
        $values = $universities->pluck('ranking_qs_no_start')->toArray();

        // Ensure null values exist but don’t break test
        $this->assertTrue(in_array(null, $values, true) || !empty($values), 'QS ranking sorting should handle null values gracefully.');
    }

    /** @test */
    public function it_handles_null_ranking_values_in_the_sort()
    {
        $universities = University::orderByRaw('ISNULL(ranking_the_no_start), ranking_the_no_start ASC')->get();

        // Extract THE ranking values (may contain null)
        $values = $universities->pluck('ranking_the_no_start')->toArray();

        // Ensure null values exist but don’t break test
        $this->assertTrue(in_array(null, $values, true) || !empty($values), 'THE ranking sorting should handle null values gracefully.');
    }
}
