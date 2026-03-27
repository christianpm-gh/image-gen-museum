<?php

namespace App\Http\Controllers;

use App\Enums\TicketType;
use App\Http\Requests\StoreOrderRequest;
use App\Services\PurchaseTicketService;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function create(): View
    {
        return view('orders.create', [
            'ticketTypes' => TicketType::cases(),
        ]);
    }

    public function store(StoreOrderRequest $request, PurchaseTicketService $purchaseTicketService)
    {
        $ticketType = TicketType::from($request->string('ticket_type')->toString());
        $order = $purchaseTicketService->purchase($request->user(), $ticketType)->fresh('ticket');

        return redirect()
            ->route('tickets.show', $order->ticket)
            ->with('status', 'Tu compra mock fue registrada y la entrada ya va en camino a tu correo.');
    }
}
