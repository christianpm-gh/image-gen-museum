<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        return view('tickets.index', [
            'tickets' => request()->user()->tickets()->with(['order', 'memoryGenerations'])->paginate(10),
        ]);
    }

    public function show(Ticket $ticket): View
    {
        abort_unless($ticket->user_id === request()->user()->id, 403);

        $ticket->load(['order', 'memoryGenerations']);

        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }
}
