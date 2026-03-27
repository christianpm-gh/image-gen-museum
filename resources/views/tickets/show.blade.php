<x-layouts.app :title="'Ticket '.$ticket->uuid">
    <div class="museum-page">
        @if (session('status'))
            <div class="museum-panel border-sky-400/30 text-sky-100">{{ session('status') }}</div>
        @endif

        <section class="museum-panel grid gap-6 lg:grid-cols-[1fr_0.8fr]">
            <div class="space-y-4">
                <p class="museum-kicker">Ticket emitido</p>
                <h1 class="museum-heading">{{ $ticket->ticket_type->label() }}</h1>
                <p class="museum-copy">UUID: {{ $ticket->uuid }}</p>
                <p class="museum-copy">Estado: {{ $ticket->status->label() }}</p>
                <p class="museum-copy">Orden: #{{ $ticket->order->id }} · ${{ number_format($ticket->order->amount / 100, 2) }} {{ $ticket->order->currency }}</p>
            </div>

            <div class="museum-panel-soft">
                <p class="text-sm font-semibold text-white">Cómo usarlo</p>
                <ul class="mt-3 space-y-3 text-sm text-slate-300">
                    <li>1. Revisa el correo de acceso que acabas de recibir.</li>
                    <li>2. Abre el enlace firmado incluido en el ticket.</li>
                    <li>3. Selecciona la cantidad exacta de referencias permitidas por tu entrada.</li>
                    <li>4. Escribe qué sentiste y envía tu generación.</li>
                </ul>
            </div>
        </section>

        <section class="museum-panel">
            <div class="flex items-center justify-between">
                <p class="museum-kicker">Historial del ticket</p>
                <a href="{{ route('memories.index') }}" class="text-sm text-sky-300">Ir a recuerdos</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($ticket->memoryGenerations as $memory)
                    <a href="{{ route('memories.show', $memory) }}" class="museum-panel-soft block">
                        <p class="font-semibold text-white">{{ $memory->status->label() }}</p>
                        <p class="mt-2 text-sm text-slate-300 line-clamp-2">{{ $memory->emotion_text }}</p>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Aún no hay recuerdos asociados. El acceso se habilita desde el correo del ticket.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.app>
