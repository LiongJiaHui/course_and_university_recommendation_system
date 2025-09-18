<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\PythonController;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Factory;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;

class PreferencesUnitTest extends TestCase
{
    // focus on the preferences data section

    private function makeValidator(array $data)
    {
        $translator = new Translator(new ArrayLoader(), 'en');
        $factory = new Factory($translator);

        $rules = [
            'unitype' => 'required|string',
            'preference' => 'array', // ensure it's an array
            'preference.*' => 'string',
            'location' => 'nullable|array',
            'location.*' => 'string',
            'area_of_interest' => 'nullable|array',
            'area_of_interest.*' => 'string',
            'tuition_fees_start' => 'nullable|numeric',
            'tuition_fees_end' => 'nullable|numeric',
        ];

        return $factory->make($data, $rules);
    }

    /** @test */
    public function it_passes_with_valid_data()
    {
        $data = [
            'unitype' => 'public',
            'preference' => ['location', 'area_of_interest'],
            'location' => ['Selangor', 'Johor'],
            'area_of_interest' => ['Engineering'],
            'tuition_fees_start' => 1000,
            'tuition_fees_end' => 5000,
        ];

        $this->assertTrue($this->makeValidator($data)->passes());
    }

    /** @test */
    public function it_fails_without_unitype()
    {
        $data = [
            'location' => ['Selangor']
        ];

        $this->assertTrue($this->makeValidator($data)->fails());
        $this->assertArrayHasKey('unitype', $this->makeValidator($data)->errors()->toArray());
    }

    /** @test */
    public function it_fails_with_non_array_location()
    {
        $data = [
            'unitype' => 'private',
            'location' => 12345, // invalid (neither string nor array)
        ];

        $this->assertTrue($this->makeValidator($data)->fails());
        $this->assertArrayHasKey('location', $this->makeValidator($data)->errors()->toArray());
    }

    /** @test */
    public function it_fails_with_non_array_area_of_interest()
    {
        $data = [
            'unitype' => 'private',
            'area_of_interest' => 54321, // invalid (neither string nor array)
        ];

        $this->assertTrue($this->makeValidator($data)->fails());
        $this->assertArrayHasKey('area_of_interest', $this->makeValidator($data)->errors()->toArray());
    }

    /** @test */
    public function it_fails_with_non_numeric_tuition_fee()
    {
        $data = [
            'unitype' => 'public',
            'tuition_fees_start' => 'abc', // invalid
        ];

        $this->assertTrue($this->makeValidator($data)->fails());
        $this->assertArrayHasKey('tuition_fees_start', $this->makeValidator($data)->errors()->toArray());
    }

    /** @test */
    public function it_passes_with_single_string_location_and_area_of_interest()
    {
        $data = [
            'unitype' => 'public',
            'location' => ['Penang'], // single string allowed
            'area_of_interest' => ['Finance'], // single string allowed
            'tuition_fees_start' => 1500,
            'tuition_fees_end' => 6000,
        ];

        $this->assertTrue($this->makeValidator($data)->passes());
    }
}
