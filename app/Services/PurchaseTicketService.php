<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\TicketType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PurchaseTicketService
{
    public function purchase(User $user, TicketType $ticketType): Order
    {
        return DB::transaction(function () use ($user, $ticketType) {
            $order = Order::create([
                'user_id' => $user->id,
                'ticket_type' => $ticketType,
                'status' => OrderStatus::Pending,
                'amount' => $ticketType->amount(),
                'currency' => config('museum.currency', 'MXN'),
                'metadata' => [
                    'source' => 'mock_checkout',
                    'required_catalog_images' => $ticketType->requiredCatalogImages(),
                ],
            ]);

            $order->update([
                'status' => OrderStatus::Completed,
                'completed_at' => now(),
            ]);

            return $order->fresh(['user', 'ticket']);
        });
    }
}
