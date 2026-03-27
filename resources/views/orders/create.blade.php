<x-layouts.app :title="'Comprar entrada'">
    <div class="museum-page">
        <section class="museum-panel">
            <p class="museum-kicker">Acceso al recorrido</p>
            <h1 class="museum-heading mt-3">Elige cómo quieres entrar a MusIAum</h1>
            <p class="mt-4 max-w-3xl museum-copy">
                La compra se confirma al instante y tu acceso llega por correo con el enlace listo para abrir el espacio de creación.
            </p>
        </section>

        <form
            method="POST"
            action="{{ route('orders.store') }}"
            class="grid gap-6 lg:grid-cols-2"
            x-data="museumSelection.single({ initialValue: @js(old('ticket_type', $ticketTypes[0]->value ?? '')) })"
        >
            @csrf

            @foreach ($ticketTypes as $type)
                <label class="museum-choice">
                    <input
                        type="radio"
                        name="ticket_type"
                        value="{{ $type->value }}"
                        class="peer sr-only"
                        x-model="selectedValue"
                        @checked(old('ticket_type', $loop->first ? $type->value : null) === $type->value)
                    >
                    <div
                        class="museum-choice-card flex h-full flex-col justify-between gap-5 hover:border-sky-400/30"
                        :class="{ 'museum-choice-card-active': isSelected(@js($type->value)) }"
                        @click="select(@js($type->value))"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-2xl font-semibold text-white">{{ $type->label() }}</span>
                                <span class="text-3xl font-bold text-sky-300">${{ number_format($type->amount() / 100, 2) }}</span>
                            </div>
                            <p class="museum-copy">{{ $type->description() }}</p>
                        </div>

                        <div class="space-y-2 text-sm text-slate-300">
                            <p>Imágenes permitidas: {{ $type->requiredCatalogImages() }}</p>
                            <p>Entrega: ticket digital con enlace de acceso</p>
                            <p>Acceso: 1 recuerdo exitoso por ticket</p>
                        </div>

                        <span class="inline-flex w-fit items-center rounded-full border border-slate-700/80 bg-slate-900/70 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-slate-300 transition peer-checked:border-sky-300/60 peer-checked:bg-sky-400/10 peer-checked:text-sky-200">
                            <span x-show="! isSelected(@js($type->value))">Seleccionar plan</span>
                            <span x-show="isSelected(@js($type->value))">Plan elegido</span>
                        </span>
                    </div>
                </label>
            @endforeach

            @error('ticket_type')
                <p class="text-sm text-rose-300">{{ $message }}</p>
            @enderror

            <div class="lg:col-span-2">
                <button type="submit" class="museum-button">Confirmar compra mock</button>
            </div>
        </form>
    </div>
</x-layouts.app>
