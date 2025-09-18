<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginPageTest extends TestCase
{

    // read the page
    /** @test */
    public function admin_can_login_with_correct_credentials()
    {
        $admin = Admin::first(); // Use any existing admin
        $this->assertNotNull($admin, 'No admin found for login test.');

        $response = $this->post('/adminLogin', [
            'admin_name' => $admin->admin_name,
            'password' => 'abcd1234', // Replace with correct plain password
        ]);

        $response->assertRedirect(route('adminMenu'));
        $this->assertEquals(session('admin_id'), $admin->id);
        $this->assertEquals(session('admin_name'), $admin->admin_name);
    }

    /** @test */
    public function login_fails_with_wrong_credentials()
    {
        $response = $this->post('/adminLogin', [
            'admin_name' => 'wrongadmin',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['admin_name']);
    }

     /** @test */
    public function it_finds_admin_by_name()
    {
        $admin = Admin::first(); // Grab any admin from the database
        $this->assertNotNull($admin, 'No admin found in the database.');
    }

    /** @test */
    public function it_checks_password_hash()
    {
        $admin = Admin::first();
        $this->assertNotNull($admin, 'No admin found in the database.');

        // Replace 'password123' with the known plain password for testing
        $this->assertTrue(Hash::check('abcd1234', $admin->password));
    }

    /** @test */
    public function login_has_no_admin_name_and_password()
    {
        $response = $this->post('/adminLogin', [
            'admin_name' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['admin_name', 'password']);
    }

}
