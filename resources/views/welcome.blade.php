<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head', ['title' => 'MusIAum'])
    </head>
    <body class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.2),_transparent_36%),linear-gradient(180deg,_#020617_0%,_#0f172a_48%,_#020617_100%)] text-slate-100">
        <main class="mx-auto flex min-h-screen w-full max-w-7xl flex-col justify-between overflow-x-clip px-4 py-6 sm:px-6 sm:py-8 lg:px-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <x-app-logo />

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:flex-wrap sm:justify-end">
                    @auth
                        <a href="{{ route('museum.index') }}" class="museum-button-secondary w-full sm:w-auto">Entrar al museo</a>
                    @else
                        <a href="{{ route('login') }}" class="museum-button-secondary w-full sm:w-auto">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="museum-button w-full sm:w-auto">Crear cuenta</a>
                    @endauth
                </div>
            </div>

            <section class="grid gap-8 py-10 sm:gap-10 sm:py-14 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:py-16">
                <div class="space-y-6">
                    <p class="museum-kicker">Museo abstracto de recuerdos</p>
                    <h1 class="max-w-3xl text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                        MusIAum convierte un recorrido emocional en una imagen que solo existe una vez.
                    </h1>
                    <p class="max-w-2xl text-base leading-7 text-slate-300 sm:text-lg sm:leading-8">
                        Recorre salas conceptuales, elige una entrada y deja que una selección de obras curadas y tu propia sensación se conviertan en un recuerdo visual íntimo.
                    </p>

                    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                        @auth
                            <a href="{{ route('museum.index') }}" class="museum-button w-full sm:w-auto">Abrir museo</a>
                        @else
                            <a href="{{ route('register') }}" class="museum-button w-full sm:w-auto">Comenzar recorrido</a>
                            <a href="{{ route('login') }}" class="museum-button-secondary w-full sm:w-auto">Ya tengo cuenta</a>
                        @endauth
                    </div>

                    <div class="grid max-w-3xl gap-4 pt-2 sm:grid-cols-3">
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">{{ $roomCount }}</p>
                            <p class="mt-2 text-sm text-slate-300">salas listas para explorar</p>
                        </div>
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">{{ $catalogImageCount }}</p>
                            <p class="mt-2 text-sm text-slate-300">obras base para combinar</p>
                        </div>
                        <div class="museum-panel-soft">
                            <p class="text-3xl font-bold text-white">2</p>
                            <p class="mt-2 text-sm text-slate-300">tipos de acceso para crear recuerdos</p>
                        </div>
                    </div>
                </div>

                <div class="museum-placeholder mx-auto w-full max-w-md rounded-[2rem] p-4 shadow-[0_30px_120px_rgba(14,165,233,0.18)] sm:p-6 lg:max-w-none">
                    <div class="relative z-10 space-y-4 rounded-[1.5rem] border border-slate-700/60 bg-slate-950/70 p-4 sm:space-y-5 sm:p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
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
