<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Staff;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffDeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a staff member with payroll records can be soft-deleted.
     */
    public function test_staff_with_payroll_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a staff member
        $staff = Staff::create([
            'name' => 'Delete Me',
            'contact_number' => '1234567890',
            'ratings' => 5,
        ]);

        // Create a payroll record (using DB directly to avoid needing the model if it's not easily available)
        DB::table('payrolls')->insert([
            'staff_id' => $staff->id,
            'period_start' => now()->startOfMonth(),
            'period_end' => now()->endOfMonth(),
            'basic_salary' => 50000,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attempt to delete
        $response = $this->delete(route('staff.destroy', $staff->id));

        $response->assertRedirect(route('staff.index'));
        $response->assertSessionHas('success', 'Staff member deleted successfully.');

        // Assert staff is soft deleted
        $this->assertSoftDeleted('staff', [
            'id' => $staff->id,
        ]);

        // Assert payroll record still exists
        $this->assertDatabaseHas('payrolls', [
            'staff_id' => $staff->id,
        ]);
    }
}
