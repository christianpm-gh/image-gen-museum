<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketAccessToken;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class TicketAccessValidator
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateOrFail(User $user, Ticket $ticket, string $plainToken): TicketAccessToken
    {
        $ticket->loadMissing('order', 'accessToken');

        if ($ticket->user_id !== $user->id) {
            throw new AuthorizationException('Este ticket no pertenece a tu cuenta.');
        }

        if ($ticket->order?->status !== OrderStatus::Completed) {
            throw ValidationException::withMessages([
                'ticket' => 'La compra todavía no está completa.',
            ]);
        }

        if (! in_array($ticket->status, [TicketStatus::Issued, TicketStatus::Reserved], true)) {
            throw ValidationException::withMessages([
                'ticket' => 'Este ticket ya no permite nuevas generaciones.',
            ]);
        }

        $accessToken = $ticket->accessToken;

        if ($accessToken === null || ! $accessToken->matches($plainToken)) {
            throw ValidationException::withMessages([
                'token' => 'El token del ticket no es válido.',
            ]);
        }

        if ($accessToken->expires_at?->isPast()) {
            throw ValidationException::withMessages([
                'token' => 'El token del ticket ya expiró.',
            ]);
        }

        return $accessToken;
    }
}
