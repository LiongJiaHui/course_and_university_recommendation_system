<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdministratorCreationTest extends TestCase
{
    /** @test */
    public function it_shows_errors_when_validation_fails()
    {
        $response = $this->post(route('admin.store'), [
            'admin_name' => 'abc', // too short
            'password' => '123',   // too short
        ]);

        $response->assertStatus(302); // redirect back
        $response->assertSessionHasErrors(['admin_name', 'password']);
    }

    /** @test */
    public function it_creates_an_admin_with_valid_data_and_hashes_password()
    {
        $data = [
            'admin_name' => 'TestAdmin',
            'password' => 'supersecretpassword',
        ];

        $response = $this->post(route('admin.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.list'));
        $response->assertSessionHas('success', 'Admin created successfully.');

        $admin = Admin::where('admin_name', 'TestAdmin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('supersecretpassword', $admin->password));

        // 🧹 cleanup so test data doesn't stay in your DB
        $admin->delete();
    }
}
