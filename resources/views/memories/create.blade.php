<x-layouts.app :title="'Generar recuerdo'">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">Generación asistida</p>
            <h1 class="museum-heading mt-3">Crear recuerdo con {{ $ticket->ticket_type->label() }}</h1>
            <p class="mt-4 museum-copy">
                Selecciona exactamente {{ $ticket->requiredCatalogImages() }} {{ $ticket->requiredCatalogImages() === 1 ? 'imagen' : 'imágenes' }}
                del catálogo y describe brevemente lo que sentiste en el museo.
            </p>
        </section>

        <form
            method="POST"
            action="{{ route('memories.store', $ticket) }}"
            class="space-y-6"
            x-data="museumSelection.multiLimit({
                requiredCount: {{ $ticket->requiredCatalogImages() }},
                initialSelected: @js(collect(old('catalog_image_ids', []))->map(fn ($id) => (string) $id)->values()),
            })"
        >
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <section class="museum-panel">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="museum-kicker">Selección activa</p>
                        <p class="mt-2 text-sm font-semibold text-white">
                            <span x-text="`Seleccionadas ${selectedIds.length}/{{ $ticket->requiredCatalogImages() }}`">Seleccionadas {{ collect(old('catalog_image_ids', []))->count() }}/{{ $ticket->requiredCatalogImages() }}</span>
                        </p>
                        <p class="mt-2 text-sm text-slate-300" x-text="helperText()">
                            Debes seleccionar {{ $ticket->requiredCatalogImages() }} {{ $ticket->requiredCatalogImages() === 1 ? 'imagen' : 'imágenes' }} antes de enviar.
                        </p>
                    </div>
                    <span class="museum-tag whitespace-nowrap">Ticket {{ $ticket->ticket_type->label() }}</span>
                </div>

                <label for="emotion_text" class="mt-6 block text-sm font-semibold text-white">¿Qué sentiste?</label>
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
                                        x-model="selectedIds"
                                        :disabled="isDisabled('{{ $image->id }}')"
                                        @checked(collect(old('catalog_image_ids', []))->map(fn ($id) => (int) $id)->contains($image->id))
                                    >
                                    <div
                                        class="museum-choice-card museum-panel-soft hover:border-sky-400/30"
                                        :class="{
                                            'museum-choice-card-active': isSelected('{{ $image->id }}'),
                                            'museum-choice-card-disabled': isDisabled('{{ $image->id }}')
                                        }"
                                    >
                                        <div class="museum-placeholder aspect-[4/3]">
                                            @if ($image->display_url)
                                                <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                        <div class="mt-4 flex items-start justify-between gap-4">
                                            <p class="text-lg font-semibold text-white">{{ $image->title }}</p>
                                            <span class="inline-flex shrink-0 items-center rounded-full border border-slate-700/80 bg-slate-900/70 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-300 transition peer-checked:border-sky-300/60 peer-checked:bg-sky-400/10 peer-checked:text-sky-200">
                                                <span x-show="! isSelected('{{ $image->id }}')">Disponible</span>
                                                <span x-show="isSelected('{{ $image->id }}')">Elegida</span>
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-300">{{ $image->description }}</p>
                                        <div class="mt-4 space-y-1 text-xs leading-5 text-slate-400">
                                            <p>Autor: {{ $image->creator_name ?? 'No especificado' }}</p>
                                            @if ($image->creator_url)
                                                <a href="{{ $image->creator_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver autor</a>
                                            @endif
                                            <p>Fuente: {{ $image->source_name ?? 'Openverse' }}</p>
                                            @if ($image->source_url)
                                                <a href="{{ $image->source_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver origen</a>
                                            @endif
                                            <p>Licencia: {{ $image->license_name ?? 'Licencia abierta' }}</p>
                                            @if ($image->license_url)
                                                <a href="{{ $image->license_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver licencia</a>
                                            @endif
                                        </div>
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

            <button
                type="submit"
                class="museum-button"
                :disabled="! canSubmit()"
                :class="{ 'museum-button-disabled': ! canSubmit() }"
            >
                Enviar a la cola de generación
            </button>
        </form>
    </div>
</x-layouts.app>
