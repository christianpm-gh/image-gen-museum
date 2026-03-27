<?php

namespace Tests\Feature;

use App\Enums\MemoryGenerationStatus;
use App\Enums\OrderStatus;
use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Models\MemoryGeneration;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ResetDemoUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_user_command_keeps_account_but_removes_history(): void
    {
        $user = User::factory()->create([
            'email' => 'demo@example.com',
        ]);

        $order = Order::factory()->for($user)->create([
            'status' => OrderStatus::Completed,
            'ticket_type' => TicketType::Premium,
        ]);

        $ticket = Ticket::factory()->for($user)->for($order)->create([
            'status' => TicketStatus::Issued,
            'ticket_type' => TicketType::Premium,
        ]);

        TicketAccessToken::factory()->for($ticket)->create();

        MemoryGeneration::factory()->for($user)->for($ticket)->create([
            'status' => MemoryGenerationStatus::Failed,
        ]);

        DB::table('sessions')->insert([
            'id' => 'demo-session',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'payload' => 'payload',
            'last_activity' => now()->timestamp,
        ]);

        $this->artisan('museum:reset-demo-user')
            ->expectsOutputToContain('Usuario demo limpio')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'demo@example.com', 'name' => 'MusIAum Demo']);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('tickets', 0);
        $this->assertDatabaseCount('ticket_access_tokens', 0);
        $this->assertDatabaseCount('memory_generations', 0);
        $this->assertDatabaseCount('sessions', 0);
    }
}
