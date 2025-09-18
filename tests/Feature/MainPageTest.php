<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainPageTest extends TestCase
{
    /** @test */
    public function main_page_loads_successfully()
    {
        $response = $this->get('/'); // Root route for Main Page
        $response->assertStatus(200);
        $response->assertSee('Please choose your role:');
    }

    /** @test */
    public function main_page_displays_student_and_admin_buttons()
    {
        $response = $this->get('/');

        $response->assertSee('Student');
        $response->assertSee('Administrator');
    }

   /** @test */
    public function main_page_check_links()
    {
        $view = $this->view('MainPage');

        $view->assertSee('studentinformation');
        $view->assertSee('adminLogin');
    }
}
