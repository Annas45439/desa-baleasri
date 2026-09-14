<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHealthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_user_is_redirected_from_health_page(): void
    {
        $response = $this->get(route('admin.health'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_open_health_page(): void
    {
        $user = User::factory()->create([
            'email' => 'health@example.com',
            'role' => 'super_admin',
        ]);

        $this->actingAs($user)
            ->get(route('admin.health'))
            ->assertOk();
    }
}
