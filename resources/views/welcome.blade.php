<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head', ['title' => 'Museo de Recuerdos IA'])
    </head>
    <body class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.2),_transparent_36%),linear-gradient(180deg,_#020617_0%,_#0f172a_48%,_#020617_100%)] text-slate-100">
        <main class="mx-auto flex min-h-screen w-full max-w-7xl flex-col justify-between px-6 py-8 lg:px-10">
            <div class="flex items-center justify-between">
                <x-app-logo />

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('museum.index') }}" class="museum-button-secondary">Entrar al museo</a>
                    @else
                        <a href="{{ route('login') }}" class="museum-button-secondary">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="museum-button">Crear cuenta</a>
                    @endauth
                </div>
            </div>

            <section class="grid gap-10 py-16 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div class="space-y-6">
                    <p class="museum-kicker">Proyecto universitario fullstack</p>
                    <h1 class="text-5xl font-bold leading-tight tracking-tight text-white sm:text-6xl">
                        Un museo conceptual donde cada entrada puede convertirse en una imagen irrepetible.
                    </h1>
                    <p class="max-w-2xl text-lg leading-8 text-slate-300">
                        Explora salas y exposiciones, compra una entrada mockeada y transforma lo que sentiste en un recuerdo visual generado con IA a partir de referencias curadas.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('museum.index') }}" class="museum-button">Abrir museo</a>
                        @else
                            <a href="{{ route('register') }}" class="museum-button">Comenzar recorrido</a>
                            <a href="{{ route('login') }}" class="museum-button-secondary">Ya tengo cuenta</a>
                        @endauth
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <span class="museum-tag">Laravel 12</span>
                        <span class="museum-tag">Livewire + Flux</span>
                        <span class="museum-tag">Supabase</span>
                        <span class="museum-tag">OpenAI Images</span>
                        <span class="museum-tag">Mailtrap</span>
                    </div>
                </div>

                <div class="museum-placeholder rounded-[2rem] p-6 shadow-[0_30px_120px_rgba(14,165,233,0.18)]">
                    <div class="relative z-10 space-y-4 rounded-[1.5rem] border border-slate-700/60 bg-slate-950/70 p-6">
                        <p class="museum-kicker">Flujo principal</p>
                        <div class="space-y-4">
                            <div class="museum-panel-soft">
                                <p class="text-sm font-semibold text-white">1. Explora el museo</p>
                                <p class="mt-2 text-sm text-slate-300">Salas curadas, exposiciones conceptuales e imágenes base listas para combinar.</p>
                            </div>
                            <div class="museum-panel-soft">
                                <p class="text-sm font-semibold text-white">2. Compra tu entrada</p>
                                <p class="mt-2 text-sm text-slate-300">La orden se marca como completada y un observer envía tu ticket por correo.</p>
                            </div>
                            <div class="museum-panel-soft">
                                <p class="text-sm font-semibold text-white">3. Genera tu recuerdo</p>
                                <p class="mt-2 text-sm text-slate-300">Selecciona 1 o 2 referencias, escribe lo que sentiste y deja que la cola procese la imagen.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="flex flex-col gap-2 border-t border-slate-800 pt-6 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>Museo de Recuerdos IA</p>
                <p>Dark mode permanente. Paleta azul, gris y blanco.</p>
            </footer>
        </main>
    </body>
</html>
