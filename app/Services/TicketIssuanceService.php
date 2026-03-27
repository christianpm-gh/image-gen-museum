<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketIssuanceService
{
    /**
     * @return array{0: \App\Models\Ticket, 1: string}
     */
    public function issueForOrder(Order $order): array
    {
        return DB::transaction(function () use ($order) {
            $order->loadMissing('ticket.accessToken', 'user');

            if ($order->ticket !== null && $order->ticket->accessToken !== null) {
                throw new \RuntimeException('La orden ya tiene un ticket emitido.');
            }

            $plainToken = Str::upper(Str::random(8).'-'.Str::random(8));

            /** @var \App\Models\Ticket $ticket */
            $ticket = $order->ticket()->create([
                'user_id' => $order->user_id,
                'uuid' => (string) Str::uuid(),
                'ticket_type' => $order->ticket_type,
                'status' => TicketStatus::Issued,
                'issued_at' => now(),
            ]);

            $ticket->accessToken()->create([
                'token_hash' => hash('sha256', $plainToken),
                'expires_at' => now()->addHours((int) config('museum.ticket_link_ttl_hours', 168)),
            ]);

            return [$ticket->fresh(['order', 'user', 'accessToken']), $plainToken];
        });
    }
}
