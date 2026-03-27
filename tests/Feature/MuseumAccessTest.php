<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuseumAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_museum(): void
    {
        $this->get(route('museum.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_museum(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('museum.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_open_profile_settings(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('settings.profile'))
            ->assertOk();
    }
}
