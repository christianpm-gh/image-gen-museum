<x-layouts.app :title="'Generar recuerdo'">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">Generación asistida</p>
            <h1 class="museum-heading mt-3">Crear recuerdo con {{ $ticket->ticket_type->label() }}</h1>
            <p class="mt-4 museum-copy">
                Selecciona exactamente {{ $ticket->requiredCatalogImages() }} {{ \Illuminate\Support\Str::plural('imagen', $ticket->requiredCatalogImages()) }}
                del catálogo y describe brevemente lo que sentiste en el museo.
            </p>
        </section>

        <form method="POST" action="{{ route('memories.store', $ticket) }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <section class="museum-panel">
                <label for="emotion_text" class="block text-sm font-semibold text-white">¿Qué sentiste?</label>
                <textarea id="emotion_text" name="emotion_text" rows="5" class="mt-3 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" placeholder="Ejemplo: sentí calma y una nostalgia muy luminosa, como si la sala estuviera respirando conmigo...">{{ old('emotion_text') }}</textarea>
                @error('emotion_text')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </section>

            <section class="space-y-5">
                @foreach ($catalogImages as $group => $images)
                    <div class="museum-panel">
                        <p class="museum-kicker">{{ $group }}</p>
                        <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            @foreach ($images as $image)
                                <label class="museum-choice">
                                    <input
                                        type="checkbox"
                                        name="catalog_image_ids[]"
                                        value="{{ $image->id }}"
                                        class="peer sr-only"
                                        @checked(collect(old('catalog_image_ids', []))->map(fn ($id) => (int) $id)->contains($image->id))
                                    >
                                    <div class="museum-choice-card museum-panel-soft hover:border-sky-400/30">
                                        <div class="museum-placeholder aspect-[4/3]">
                                        @if ($image->display_url)
                                            <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                                        @endif
                                        </div>
                                        <div class="mt-4 flex items-start justify-between gap-4">
                                            <p class="text-lg font-semibold text-white">{{ $image->title }}</p>
                                            <span class="inline-flex shrink-0 items-center rounded-full border border-slate-700/80 bg-slate-900/70 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-300 transition peer-checked:border-sky-300/60 peer-checked:bg-sky-400/10 peer-checked:text-sky-200">
                                                Elegida
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-300">{{ $image->description }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('catalog_image_ids')
                    <p class="text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </section>

            <button type="submit" class="museum-button">Enviar a la cola de generación</button>
        </form>
    </div>
</x-layouts.app>
