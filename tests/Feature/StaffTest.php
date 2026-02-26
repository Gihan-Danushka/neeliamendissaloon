<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Staff;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffTest extends TestCase
{
    // use RefreshDatabase; // Use if you want clean DB for each test, but be careful with existing data

    /**
     * A basic test example.
     */
    public function test_staff_can_be_created_with_new_fields(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();

        $response = $this->post(route('staff.store'), [
            'name' => 'Test Staff',
            'contact_number' => '1234567890',
            'ratings' => 5,
            'category_ids' => [$category->id],
            'experience' => '5 Years',
            'join_date' => '2023-01-01',
            'bank_account_number' => '123456789',
            'bank_name' => 'Test Bank',
            'basic_salary' => 50000,
            'etf_number' => 'ETF123',
            'attendance_allowance' => 5000,
        ]);

        $response->assertRedirect(route('staff.index'));
        $this->assertDatabaseHas('staff', [
            'name' => 'Test Staff',
            'experience' => '5 Years',
            'bank_name' => 'Test Bank',
            'basic_salary' => 50000,
            'attendance_allowance' => 5000,
        ]);
    }

    public function test_staff_can_be_updated_with_new_fields(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $category = Category::factory()->create();
        $staff = Staff::create([
            'name' => 'Original Name',
            'contact_number' => '0000000000',
            'ratings' => 3,
            'experience' => 'Old Experience',
        ]);
        $staff->categories()->attach($category->id);

        $response = $this->put(route('staff.update', $staff->id), [
            'name' => 'Updated Name',
            'contact_number' => '0000000000',
            'ratings' => 3,
            'category_ids' => [$category->id],
            'experience' => 'New Experience',
            'join_date' => '2024-01-01',
            'bank_account_number' => '987654321',
            'bank_name' => 'New Bank',
            'basic_salary' => 60000,
            'etf_number' => 'ETF456',
            'attendance_allowance' => 7000,
        ]);

        $response->assertRedirect(route('staff.index'));
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'name' => 'Updated Name',
            'experience' => 'New Experience',
            'basic_salary' => 60000,
            'attendance_allowance' => 7000,
        ]);
    }
}
