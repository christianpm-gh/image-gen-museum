<x-layouts.app :title="'Recuerdo '.$memory->id">
    <div class="museum-page">
        @if (session('status'))
            <div class="museum-panel border-sky-400/30 text-sky-100">{{ session('status') }}</div>
        @endif

        <section class="museum-panel grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="museum-placeholder aspect-[4/3]">
            @if ($memory->display_url)
                <img src="{{ $memory->display_url }}" alt="Recuerdo generado" class="h-full w-full object-cover">
                @endif
            </div>

            <div class="space-y-4">
                <p class="museum-kicker">Estado</p>
                <h1 class="museum-heading">{{ $memory->status->label() }}</h1>
                <p class="museum-copy">{{ $memory->emotion_text }}</p>
                <p class="text-sm text-slate-400">Ticket: {{ $memory->ticket->ticket_type->label() }}</p>
                @if ($memory->error_message)
                    <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-200">
                        {{ $memory->error_message }}
                    </div>
                @endif
            </div>
        </section>

        <section class="museum-panel">
            <p class="museum-kicker">Referencias seleccionadas</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($selectedCatalogImages as $image)
                    <article class="museum-panel-soft">
                        <div class="museum-placeholder aspect-[4/3]">
                            @if ($image->display_url)
                                <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <p class="mt-4 font-semibold text-white">{{ $image->title }}</p>
                        <p class="mt-2 text-sm text-slate-300">{{ $image->exhibition->title }}</p>
                        <div class="mt-3 space-y-1 text-xs leading-5 text-slate-400">
                            <p>{{ $image->attribution_text }}</p>
                            <div class="flex flex-wrap gap-3">
                                @if ($image->source_url)
                                    <a href="{{ $image->source_url }}" target="_blank" rel="noreferrer" class="text-sky-300 hover:text-sky-200">Fuente</a>
                                @endif
                                @if ($image->license_url)
                                    <a href="{{ $image->license_url }}" target="_blank" rel="noreferrer" class="text-sky-300 hover:text-sky-200">Licencia</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.app>
