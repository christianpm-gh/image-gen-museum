<?php

namespace Tests\Feature;

use App\Mail\TicketIssuedMail;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TicketPurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_mock_purchase_creates_ticket_and_queues_email(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/tickets/comprar', [
                'ticket_type' => 'standard',
            ])
            ->assertRedirect();

        $order = Order::query()->with('ticket.accessToken')->first();

        $this->assertNotNull($order);
        $this->assertNotNull($order->ticket);
        $this->assertNotNull($order->ticket->accessToken);

        Mail::assertQueued(TicketIssuedMail::class);
    }

    public function test_ticket_email_can_generate_a_signed_link_for_a_custom_origin(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();
        $ticket = Ticket::factory()->for($user)->for($order)->create();

        $mail = new TicketIssuedMail($ticket, 'TOKEN-1234', 'http://127.0.0.1:8000');
        $accessUrl = $mail->content()->with['accessUrl'] ?? null;

        $this->assertIsString($accessUrl);
        $this->assertStringStartsWith('http://127.0.0.1:8000/', $accessUrl);
    }
}
