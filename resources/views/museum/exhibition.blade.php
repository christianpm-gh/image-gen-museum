<x-layouts.app :title="$exhibition->title">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">{{ $exhibition->museumRoom->title }}</p>
            <h1 class="museum-heading mt-3">{{ $exhibition->title }}</h1>
            <p class="mt-4 max-w-3xl museum-copy">{{ $exhibition->description }}</p>
            <div class="mt-5 grid gap-3 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-800/80 bg-slate-950/65 px-4 py-3 text-sm text-slate-300">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-sky-300">Resumen</p>
                    <p class="mt-2">{{ $exhibition->summary }}</p>
                </div>
                @if ($exhibition->curator_note)
                    <div class="rounded-2xl border border-slate-800/80 bg-slate-950/65 px-4 py-3 text-sm text-slate-300">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-sky-300">Nota curatorial</p>
                        <p class="mt-2">{{ $exhibition->curator_note }}</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($exhibition->catalogImages as $image)
                <article class="museum-panel-soft">
                    <div class="museum-placeholder museum-card-media">
                        @if ($image->display_url)
                            <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <p class="museum-card-title mt-4">{{ $image->title }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $image->description }}</p>
                    <div class="mt-4 rounded-2xl border border-slate-800/80 bg-slate-950/65 px-4 py-3 text-xs leading-5 text-slate-400">
                        <p><span class="text-slate-200">Paleta:</span> {{ $image->palette }}</p>
                        <p>{{ $image->attribution_text }}</p>
                        <div class="mt-3 flex flex-wrap gap-3">
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
        </section>
    </div>
</x-layouts.app>
