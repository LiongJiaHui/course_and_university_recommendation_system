<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class AdministratorCreationUnitTest extends TestCase
{
    private $rules = [
        'admin_name' => 'required|string|min:4',
        'password' => 'required|string|min:8',
    ];

    /** @test */
    public function admin_name_and_password_are_not_required()
    {
        $data = [
            'admin_name' => '',
            'password' => '',
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('admin_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function unvalid_admin_name_which_less_than_four_characters()
    {
        $data = [
            'admin_name' => 'abc', // too short
            'password' => 'longenoughpassword',
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('admin_name', $validator->errors()->toArray());
    }

    /** @test */
    public function unvalid_password_which_less_than_eight_characters()
    {
        $data = [
            'admin_name' => 'ValidName',
            'password' => 'short', // too short
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function valid_data_passes_validation()
    {
        $data = [
            'admin_name' => 'ValidName',
            'password' => 'longpassword',
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertFalse($validator->fails());
    }
}
