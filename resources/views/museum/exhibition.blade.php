<x-layouts.app :title="$exhibition->title">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">{{ $exhibition->museumRoom->title }}</p>
            <h1 class="museum-heading mt-3">{{ $exhibition->title }}</h1>
            <p class="mt-4 max-w-3xl museum-copy">{{ $exhibition->description }}</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <span class="museum-tag">{{ $exhibition->summary }}</span>
                @if ($exhibition->curator_note)
                    <span class="museum-tag">{{ $exhibition->curator_note }}</span>
                @endif
            </div>
        </section>

        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($exhibition->catalogImages as $image)
                <article class="museum-panel-soft">
                    <div class="museum-placeholder aspect-[4/3]">
                        @if ($image->display_url)
                            <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <p class="mt-4 text-lg font-semibold text-white">{{ $image->title }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $image->description }}</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-slate-400">{{ $image->palette }}</p>
                    <div class="mt-4 space-y-1 text-xs leading-5 text-slate-400">
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
        </section>
    </div>
</x-layouts.app>
