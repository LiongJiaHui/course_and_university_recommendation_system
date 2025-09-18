<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin;

class AdministratorListUnitTest extends TestCase
{
   /** @test */
    public function it_filters_admins_by_name()
    {
        $keyword = 'Admin1';

        $result = Admin::query()
            ->where('admin_name', 'LIKE', "%{$keyword}%")
            ->paginate(5);

        $this->assertNotEmpty($result);
        $this->assertTrue(
            $result->contains(fn($admin) => stripos($admin->admin_name, $keyword) !== false)
        );
    }

    /** @test */
    public function it_returns_empty_when_no_admin_matches()
    {
        $keyword = 'NonExistentAdminName123';

        $result = Admin::query()
            ->where('admin_name', 'LIKE', "%{$keyword}%")
            ->paginate(5);

        $this->assertCount(0, $result);
    }

     /** @test */
    public function it_deletes_an_admin_record_from_database()
    {
        // Arrange: create a fake admin
        $admin = Admin::factory()->create();

        // Act: delete the record
        $admin->delete();

        // Assert: record no longer exists
        $this->assertDatabaseMissing('admins', ['id' => $admin->id]);

        // Cleanup (just in case)
        Admin::where('id', $admin->id)->delete();
    }
}
