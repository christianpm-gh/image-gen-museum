<x-layouts.app :title="'Mis recuerdos'">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">Galería privada</p>
            <h1 class="museum-heading mt-3">Mis recuerdos generados</h1>
            <p class="mt-4 museum-copy">Aquí se guardan tus recuerdos terminados y el estado de los que siguen en proceso.</p>
        </section>

        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($memories as $memory)
                <a href="{{ route('memories.show', $memory) }}" class="museum-panel block transition hover:border-sky-400/30">
                    <div class="museum-placeholder aspect-[4/3]">
                        @if ($memory->display_url)
                            <img src="{{ $memory->display_url }}" alt="Recuerdo generado" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <p class="mt-4 text-lg font-semibold text-white">{{ $memory->status->label() }}</p>
                    <p class="mt-2 text-sm text-slate-300 line-clamp-3">{{ $memory->emotion_text }}</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-slate-400">{{ $memory->ticket->ticket_type->label() }}</p>
                </a>
            @empty
                <div class="museum-panel md:col-span-2 xl:col-span-3 text-sm text-slate-300">Tu galería está vacía. Compra una entrada y usa el enlace del correo para crear tu primer recuerdo.</div>
            @endforelse
        </section>

        {{ $memories->links() }}
    </div>
</x-layouts.app>
