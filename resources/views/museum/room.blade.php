<x-layouts.app :title="$room->title">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">{{ $room->hero_eyebrow }}</p>
            <div class="mt-3 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="museum-heading">{{ $room->title }}</h1>
                    <p class="mt-4 max-w-3xl museum-copy">{{ $room->description }}</p>
                </div>
                <a href="{{ route('tickets.purchase') }}" class="museum-button">Comprar entrada</a>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            @foreach ($room->exhibitions as $exhibition)
                <article class="museum-panel">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-2xl font-semibold text-white">{{ $exhibition->title }}</p>
                            <p class="mt-3 museum-copy">{{ $exhibition->summary }}</p>
                        </div>
                        <span class="museum-tag">{{ $exhibition->catalogImages->count() }} obras</span>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @foreach ($exhibition->catalogImages as $image)
                            <div class="museum-placeholder aspect-[4/3]">
                            @if ($image->display_url)
                                <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="rounded-2xl border border-slate-800/80 bg-slate-950/65 px-4 py-3 text-sm text-slate-300">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-sky-300">Nota curatorial</p>
                            <p class="mt-2">{{ $exhibition->curator_note }}</p>
                        </div>
                        <a href="{{ route('museum.exhibitions.show', $exhibition) }}" class="museum-button-secondary">Ver exposición</a>
                    </div>
                </article>
            @endforeach
        </section>
    </div>
</x-layouts.app>
