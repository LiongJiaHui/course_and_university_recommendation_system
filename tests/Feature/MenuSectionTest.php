<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MenuSectionTest extends TestCase
{
     /** @test */
    public function admin_menu_page_loads_successfully()
    {
        $response = $this->get('adminMenu'); // adjust route if different

        $response->assertStatus(200);
        $response->assertSee('Administrator Menu Section');
    }

    /** @test */
    public function admin_menu_page_has_university_link()
    {
        $view = $this->view('Administrator.MenuSection'); // blade file name (adjust if needed)

        $view->assertSee('/University');
        $view->assertSee('University');
    }

    /** @test */
    public function admin_menu_page_has_course_category_link()
    {
        $view = $this->view('Administrator.MenuSection');

        $view->assertSee('/CourseCategory');
        $view->assertSee('Course Category');
    }

    /** @test */
    public function admin_menu_page_has_course_information_link()
    {
        $view = $this->view('Administrator.MenuSection');

        $view->assertSee('/Course');
        $view->assertSee('Course Information');
    }

    /** @test */
    public function admin_menu_page_has_admin_management_link()
    {
        $view = $this->view('Administrator.MenuSection');

        $view->assertSee('Administrator Management');
    }

    /** @test */
    public function admin_menu_page_has_logout_button()
    {
        $view = $this->view('Administrator.MenuSection');

        $view->assertSee('Log Out');
        $view->assertSee('adminLogin');
    }
}
