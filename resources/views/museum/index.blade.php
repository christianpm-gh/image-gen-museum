<x-layouts.app :title="'Museo'">
    <div class="museum-page">
        @if (session('status'))
            <div class="museum-panel border-sky-400/30 text-sky-100">{{ session('status') }}</div>
        @endif

        <section class="museum-panel grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="space-y-5">
                <p class="museum-kicker">Recorrido curado</p>
                <h1 class="museum-heading">Explora salas, activa tu acceso y transforma una emoción en un recuerdo visual.</h1>
                <p class="museum-copy">
                    Cada entrada abre una forma distinta de mirar el museo. Recorre las salas, encuentra la obra que te acompañe y conviértela en el punto de partida de una imagen íntima.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tickets.purchase') }}" class="museum-button">Comprar entrada</a>
                    <a href="{{ route('tickets.index') }}" class="museum-button-secondary">Ver mis tickets</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="museum-panel-soft">
                    <p class="museum-kicker">Tus tickets</p>
                    <p class="mt-3 text-4xl font-bold text-white">{{ $tickets->count() }}</p>
                    <p class="mt-2 text-sm text-slate-300">Accesos recientes listos para usar.</p>
                </div>
                <div class="museum-panel-soft">
                    <p class="museum-kicker">Recuerdos</p>
                    <p class="mt-3 text-4xl font-bold text-white">{{ $recentMemories->count() }}</p>
                    <p class="mt-2 text-sm text-slate-300">Generaciones recientes dentro de tu galería privada.</p>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="space-y-6">
                @foreach ($rooms as $room)
                    <article class="museum-panel">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="space-y-3">
                                <p class="museum-kicker">{{ $room->hero_eyebrow }}</p>
                                <h2 class="text-2xl font-semibold text-white">{{ $room->title }}</h2>
                                <p class="museum-copy max-w-3xl">{{ $room->summary }}</p>
                            </div>

                            <a href="{{ route('museum.rooms.show', $room) }}" class="museum-button-secondary">Entrar a la sala</a>
                        </div>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            @foreach ($room->exhibitions as $exhibition)
                                <a href="{{ route('museum.exhibitions.show', $exhibition) }}" class="museum-panel-soft block transition hover:border-sky-400/30">
                                    <div class="flex items-start justify-between gap-4">
                                <div>
                                            <p class="text-lg font-semibold text-white">{{ $exhibition->title }}</p>
                                            <p class="mt-2 text-sm text-slate-300">{{ $exhibition->summary }}</p>
                                        </div>
                                        <span class="museum-tag">{{ $exhibition->catalogImages->count() }} obras</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="space-y-6">
                <div class="museum-panel">
                    <p class="museum-kicker">Entradas</p>
                    <div class="mt-4 space-y-4">
                        @foreach (\App\Enums\TicketType::cases() as $type)
                            <div class="museum-panel-soft">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-white">{{ $type->label() }}</p>
                                        <p class="mt-1 text-sm text-slate-300">{{ $type->description() }}</p>
                                    </div>
                                    <p class="text-xl font-bold text-sky-300">${{ number_format($type->amount() / 100, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="museum-panel">
                    <div class="flex items-center justify-between">
                        <p class="museum-kicker">Galería reciente</p>
                        <a href="{{ route('memories.index') }}" class="text-sm text-sky-300">Ver todo</a>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse ($recentMemories as $memory)
                            <a href="{{ route('memories.show', $memory) }}" class="museum-panel-soft block transition hover:border-sky-400/30">
                                <p class="font-semibold text-white">{{ $memory->ticket->ticket_type->label() }}</p>
                                <p class="mt-2 text-sm text-slate-300 line-clamp-3">{{ $memory->emotion_text }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-400">Todavía no generas recuerdos. Compra una entrada para empezar.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>
    </div>
</x-layouts.app>
