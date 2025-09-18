<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class UniversityUpdateUnitTest extends TestCase
{
    private array $rules = [
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

    /** @test */
    public function it_fails_when_required_fields_are_missing()
    {
        $data = []; // empty submission
        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('uni_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /** @test */
    public function it_requires_valid_email()
    {
        $data = ['email' => 'invalid-email'];
        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    /** @test */
    public function it_passes_with_valid_data()
    {
        $data = [
            'uni_name' => 'Test University',
            'uni_address' => '123 Street',
            'postcode' => '50000',
            'area' => 'Kuala Lumpur',
            'state_id' => 1,
            'campus' => 'Main Campus',
            'website' => 'https://uni.edu',
            'uni_type' => 'Public',
            'contact_no' => '609-1234567',
            'email' => 'valid@uni.edu',
            'admin_id' => 1
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertFalse($validator->fails());
    }
}
