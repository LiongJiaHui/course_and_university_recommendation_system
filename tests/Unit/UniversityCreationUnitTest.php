<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\University;
use Illuminate\Support\Facades\Validator;

class UniversityCreationUnitTest extends TestCase
{
   private function rules()
    {
        return [
            'uni_name' => 'required',
            'uni_address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state_id' => 'required',
            'campus' => 'required', 
            'website' => 'required',
            'uni_type' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email',
            'ranking_qs_no_start' => 'nullable', 
            'ranking_qs_no_end' => 'nullable',
            'ranking_qs_year' => 'nullable',
            'ranking_the_no_start' => 'nullable',
            'ranking_the_no_end' => 'nullable',
            'ranking_the_year' => 'nullable',
            'admin_id' => 'required'
        ];
    }

    /** @test */
    public function it_allows_valid_data()
    {
        $data = [
            'uni_name' => 'Unit Test University',
            'uni_address' => '123 Test Street',
            'postcode' => '50300',
            'area' => 'Kuala Lumpur',
            'state_id' => 1,
            'campus' => 'Main Campus',
            'website' => 'https://example.com',
            'uni_type' => 'Public',
            'contact_no' => '609-1234567',
            'email' => 'unit@test.com',
            'admin_id' => 1,
        ];

        $validator = Validator::make($data, $this->rules());
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_rejects_missing_fields()
    {
        $data = [
            'uni_name' => '', // required
            'email' => 'not-an-email',
            'contact_no' => '',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('uni_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('contact_no', $validator->errors()->toArray());
    }
}
