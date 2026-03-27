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
            class="space-y-6 pb-64"
            x-data="{
                ...museumSelection.multiLimit({
                    requiredCount: {{ $ticket->requiredCatalogImages() }},
                    initialSelected: @js(collect(old('catalog_image_ids', []))->map(fn ($id) => (string) $id)->values()),
                }),
                emotionText: @js(old('emotion_text', '')),
                emotionMax: 280,
            }"
        >
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

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
                                        <div class="museum-placeholder museum-card-media">
                                            @if ($image->display_url)
                                                <img src="{{ $image->display_url }}" alt="{{ $image->alt_text }}" class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                        <div class="museum-card-header mt-4">
                                            <p class="museum-card-title">{{ $image->title }}</p>
                                            <span class="inline-flex shrink-0 self-start items-center rounded-full border border-slate-700/80 bg-slate-900/70 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-300 transition peer-checked:border-sky-300/60 peer-checked:bg-sky-400/10 peer-checked:text-sky-200">
                                                <span x-show="! isSelected('{{ $image->id }}')">Disponible</span>
                                                <span x-show="isSelected('{{ $image->id }}')">Elegida</span>
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-slate-300">{{ $image->description }}</p>
                                        <div class="mt-4 rounded-2xl border border-slate-800/80 bg-slate-950/65 px-4 py-3 text-xs leading-5 text-slate-400">
                                            <div class="grid gap-2 sm:grid-cols-2">
                                                <p><span class="text-slate-200">Autor:</span> {{ $image->creator_name ?? 'No especificado' }}</p>
                                                <p><span class="text-slate-200">Fuente:</span> {{ $image->source_name ?? 'Archivo curado' }}</p>
                                                <p class="sm:col-span-2"><span class="text-slate-200">Licencia:</span> {{ $image->license_name ?? 'Licencia abierta' }}</p>
                                            </div>
                                            <div class="mt-3 flex flex-wrap gap-3">
                                                @if ($image->creator_url)
                                                    <a href="{{ $image->creator_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver autor</a>
                                                @endif
                                                @if ($image->source_url)
                                                    <a href="{{ $image->source_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver origen</a>
                                                @endif
                                                @if ($image->license_url)
                                                    <a href="{{ $image->license_url }}" target="_blank" rel="noreferrer" class="inline-flex text-sky-300 hover:text-sky-200">Ver licencia</a>
                                                @endif
                                            </div>
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

            <div class="museum-floating-action">
                <div class="museum-floating-action-shell">
                    <div class="museum-floating-status">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-sky-300">Recuerdo listo</p>
                        <p class="mt-2 text-sm text-slate-300">
                            <span x-text="`Seleccionadas ${selectedIds.length}/{{ $ticket->requiredCatalogImages() }}`">Seleccionadas {{ collect(old('catalog_image_ids', []))->count() }}/{{ $ticket->requiredCatalogImages() }}</span>
                            <span class="mx-2 text-slate-600">·</span>
                            {{ $ticket->ticket_type->label() }}
                        </p>
                        <p class="mt-2 text-sm text-slate-400" x-text="helperText()">
                            Debes seleccionar {{ $ticket->requiredCatalogImages() }} {{ $ticket->requiredCatalogImages() === 1 ? 'imagen' : 'imágenes' }} antes de enviar.
                        </p>
                    </div>

                    <div class="museum-floating-field">
                        <div class="flex items-center justify-between gap-4">
                            <label for="emotion_text" class="text-sm font-semibold text-white">¿Qué sentiste?</label>
                            <p class="text-xs text-slate-400">
                                <span x-text="emotionText.length">0</span>/280
                            </p>
                        </div>
                        <textarea
                            id="emotion_text"
                            name="emotion_text"
                            rows="3"
                            maxlength="280"
                            x-model="emotionText"
                            class="museum-floating-textarea"
                            placeholder="Escribe una sensación breve, clara y personal sobre tu recorrido..."
                        >{{ old('emotion_text') }}</textarea>
                        @error('emotion_text')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="museum-button museum-floating-submit"
                        :disabled="! canSubmit()"
                        :class="{ 'museum-button-disabled': ! canSubmit() }"
                    >
                        Enviar recuerdo
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
