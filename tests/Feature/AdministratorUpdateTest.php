<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AdministratorUpdateTest extends TestCase
{
    /** @test */
    public function it_updates_admin_with_valid_data()
    {
        $uniqueName = 'OriginalAdmin_' . time(); // ensures uniqueness
        $admin = Admin::create([
            'admin_name' => $uniqueName,
            'password'   => bcrypt('oldpassword'),
        ]);

        $response = $this->put(route('admin.update', $admin->id), [
            'admin_name' => 'UpdatedAdmin_' . time(),
            'password'   => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.list'))
                ->assertSessionHas('success');

        $admin->refresh();

        $this->assertStringStartsWith('UpdatedAdmin_', $admin->admin_name);
        $this->assertTrue(Hash::check('newpassword123', $admin->password));
    }

    /** @test */
    public function it_fails_update_with_invalid_data()
    {
        $uniqueName = 'ValidAdmin_' . time();
        $admin = Admin::create([
            'admin_name' => $uniqueName,
            'password'   => bcrypt('validpassword'),
        ]);

        $response = $this->put(route('admin.update', $admin->id), [
            'admin_name' => 'Jo', // too short
            'password'   => '123', // too short
        ]);

        $response->assertSessionHasErrors(['admin_name', 'password']);
    }
}
