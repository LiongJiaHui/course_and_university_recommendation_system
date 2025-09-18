<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AdministratorUpdateUnitTest extends TestCase
{
    /** @test */
    public function updates_for_unvalid_admin_name_and_password()
    {
        $data = [
            'admin_name' => 'Jo',   // too short
            'password'   => '123',  // too short
        ];

        $rules = [
            'admin_name' => 'required|string|min:4',
            'password'   => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('admin_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    /** @test */
    public function it_updates_admin_name_and_password()
    {
        $admin = new Admin([
            'admin_name' => 'OriginalName',
            'password'   => 'oldpassword',
        ]);

        $newData = [
            'admin_name' => 'UpdatedName',
            'password'   => 'newpassword123',
        ];

        $admin->fill($newData);

        $this->assertEquals('UpdatedName', $admin->admin_name);
        $this->assertEquals('newpassword123', $admin->password);
    }
}
