<x-layouts.app :title="'Mis tickets'">
    <div class="museum-page">
        <section class="museum-panel flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="museum-kicker">Entradas emitidas</p>
                <h1 class="museum-heading mt-3">Mis tickets</h1>
                <p class="mt-4 museum-copy">Cada ticket funciona como comprobante de acceso al generador de recuerdos.</p>
            </div>
            <a href="{{ route('tickets.purchase') }}" class="museum-button">Comprar otra entrada</a>
        </section>

        <section class="space-y-4">
            @forelse ($tickets as $ticket)
                <article class="museum-panel flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <p class="text-xl font-semibold text-white">{{ $ticket->ticket_type->label() }}</p>
                        <p class="text-sm text-slate-300">UUID: {{ $ticket->uuid }}</p>
                        <p class="text-sm text-slate-400">Estado: {{ $ticket->status->label() }}</p>
                    </div>
                    <a href="{{ route('tickets.show', $ticket) }}" class="museum-button-secondary">Ver ticket</a>
                </article>
            @empty
                <div class="museum-panel text-sm text-slate-300">Todavía no tienes tickets. Compra tu primera entrada para usar el generador.</div>
            @endforelse
        </section>

        {{ $tickets->links() }}
    </div>
</x-layouts.app>
