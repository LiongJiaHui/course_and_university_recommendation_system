<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;

class AdministratorListTest extends TestCase
{
     /** @test */
    public function it_shows_matching_admin_in_the_search_results()
    {
        $admin = Admin::first(); // dynamically use first admin
        $response = $this->get(route('admin.list', ['search' => $admin->admin_name]));

        $response->assertStatus(200);
        $response->assertSee($admin->admin_name);
    }

    /** @test */
    public function it_shows_empty_result_when_no_admin_matches()
    {
        $response = $this->get(route('admin.list', ['search' => 'NonExistentAdminName123']));

        $response->assertStatus(200);
        $response->assertSee('No admins found');
    }

    /** @test */
    public function it_displays_pagination_links_in_the_admin_list()
    {
        // Create 10 admins to ensure pagination appears
        Admin::factory()->count(10)->create();

        $response = $this->get(route('admin.list'));

        $response->assertStatus(200);
        $response->assertSee('<ul class="pagination"', false);
    }

    /** @test */
    public function it_deletes_an_admin_and_redirects_with_success_message()
    {
        // Arrange: create a fake admin
        $admin = Admin::factory()->create();

        // Act: send a delete request
        $response = $this->delete(route('admin.destroy', $admin->id));

        // Assert: record is removed
        $this->assertDatabaseMissing('admins', ['id' => $admin->id]);

        // Assert: redirected to list with success flash message
        $response->assertRedirect(route('admin.list'));
        $response->assertSessionHas('success', 'Admin deleted Successfully');

        // Cleanup: ensure no leftover record
        Admin::where('id', $admin->id)->delete();
    }

    /** @test */
    public function it_returns_404_if_admin_not_found()
    {
        // Act: Try deleting a non-existing admin
        $response = $this->delete(route('admin.destroy', 999999));

        // Assert: should return 404
        $response->assertStatus(404);
    }
}
