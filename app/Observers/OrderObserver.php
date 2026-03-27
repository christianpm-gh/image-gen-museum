<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Mail\TicketIssuedMail;
use App\Models\Order;
use App\Services\TicketIssuanceService;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Mail;

class OrderObserver implements ShouldHandleEventsAfterCommit
{
    public function __construct(
        protected TicketIssuanceService $ticketIssuanceService,
    ) {
    }

    public function updated(Order $order): void
    {
        if (! $order->wasChanged('status') || $order->status !== OrderStatus::Completed || $order->ticket()->exists()) {
            return;
        }

        [$ticket, $plainToken] = $this->ticketIssuanceService->issueForOrder($order->fresh('user'));
        $rootUrl = request()->server('HTTP_HOST')
            ? request()->getSchemeAndHttpHost()
            : null;

        Mail::to($order->user)->queue(new TicketIssuedMail($ticket, $plainToken, $rootUrl));
    }
}
