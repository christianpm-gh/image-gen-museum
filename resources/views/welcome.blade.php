<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head', ['title' => 'MusIAum'])
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
                    <p class="museum-kicker">Museo abstracto de recuerdos</p>
                    <h1 class="text-5xl font-bold leading-tight tracking-tight text-white sm:text-6xl">
                        MusIAum convierte un recorrido emocional en una imagen que solo existe una vez.
                    </h1>
                    <p class="max-w-2xl text-lg leading-8 text-slate-300">
                        Recorre salas conceptuales, elige una entrada y deja que una selección de obras curadas y tu propia sensación se conviertan en un recuerdo visual íntimo.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('museum.index') }}" class="museum-button">Abrir museo</a>
                        @else
                            <a href="{{ route('register') }}" class="museum-button">Comenzar recorrido</a>
                            <a href="{{ route('login') }}" class="museum-button-secondary">Ya tengo cuenta</a>
                        @endauth
                    </div>

                    <div class="grid max-w-3xl gap-4 pt-2 sm:grid-cols-3">
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">2</p>
                            <p class="mt-2 text-sm text-slate-300">salas listas para explorar</p>
                        </div>
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">8</p>
                            <p class="mt-2 text-sm text-slate-300">obras base para combinar</p>
                        </div>
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">2</p>
                            <p class="mt-2 text-sm text-slate-300">tipos de acceso para crear recuerdos</p>
                        </div>
                    </div>
                </div>

                <div class="museum-placeholder rounded-[2rem] p-6 shadow-[0_30px_120px_rgba(14,165,233,0.18)]">
                    <div class="relative z-10 space-y-5 rounded-[1.5rem] border border-slate-700/60 bg-slate-950/70 p-6">
                        <div class="flex items-center gap-4">
                            <x-branding.atrium-mark class="h-16 w-16 shrink-0" />
                            <div>
                                <p class="museum-kicker">Identidad principal</p>
                                <p class="mt-2 text-2xl font-semibold text-white">MusIAum</p>
                                <p class="mt-1 text-sm text-slate-300">Arquitectura, memoria y luz reunidas en un solo gesto visual.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="museum-panel-soft text-center">
                                <x-branding.atrium-mark class="mx-auto h-14 w-14" />
                                <p class="mt-3 text-sm font-semibold text-white">Atrio</p>
                                <p class="mt-1 text-xs text-slate-400">Portal y sala interior</p>
                            </div>
                            <div class="museum-panel-soft text-center">
                                <x-branding.prism-mark class="mx-auto h-14 w-14" />
                                <p class="mt-3 text-sm font-semibold text-white">Prisma</p>
                                <p class="mt-1 text-xs text-slate-400">Recorrido facetado</p>
                            </div>
                            <div class="museum-panel-soft text-center">
                                <x-branding.vault-mark class="mx-auto h-14 w-14" />
                                <p class="mt-3 text-sm font-semibold text-white">Bóveda</p>
                                <p class="mt-1 text-xs text-slate-400">Memoria resguardada</p>
                            </div>
                        </div>

                        <div class="museum-panel-soft">
                            <p class="museum-kicker">Experiencia</p>
                            <div class="mt-4 space-y-3 text-sm text-slate-300">
                                <p><span class="font-semibold text-white">1.</span> Recorre salas y elige una obra que resuene contigo.</p>
                                <p><span class="font-semibold text-white">2.</span> Activa tu acceso y recibe un ticket listo para abrir el generador.</p>
                                <p><span class="font-semibold text-white">3.</span> Describe lo que sentiste y deja que el museo traduzca esa emoción.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="flex flex-col gap-2 border-t border-slate-800 pt-6 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>MusIAum</p>
                <p>Museo conceptual para recuerdos visuales únicos.</p>
            </footer>
        </main>
    </body>
</html>
