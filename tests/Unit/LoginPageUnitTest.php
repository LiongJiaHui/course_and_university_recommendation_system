<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginPageUnitTest extends TestCase
{
     /** @test */
    public function it_checks_password_with_hash()
    {
        $plain = 'password123';
        $hashed = Hash::make($plain);

        $this->assertTrue(Hash::check($plain, $hashed));
        $this->assertFalse(Hash::check('wrongpass', $hashed));
    }

    /** @test */
    public function validation_fails_if_admin_name_is_missing()
    {
        $data = ['password' => 'password123'];
        $rules = [
            'admin_name' => 'required|string|min:4',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('admin_name', $validator->errors()->toArray());
    }

    /** @test */
    public function validation_fails_if_password_is_missing()
    {
        $data = ['admin_name' => 'adminUser'];
        $rules = [
            'admin_name' => 'required|string|min:4',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function validation_fails_if_admin_name_is_too_short()
    {
        $data = ['admin_name' => 'adm', 'password' => 'password123'];
        $rules = [
            'admin_name' => 'required|string|min:4',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('admin_name', $validator->errors()->toArray());
    }

    /** @test */
    public function validation_fails_if_password_is_too_short()
    {
        $data = ['admin_name' => 'adminUser', 'password' => 'short'];
        $rules = [
            'admin_name' => 'required|string|min:4',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function validation_passes_with_valid_data()
    {
        $data = ['admin_name' => 'adminUser', 'password' => 'password123'];
        $rules = [
            'admin_name' => 'required|string|min:4',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $this->assertFalse($validator->fails());
    }
}
