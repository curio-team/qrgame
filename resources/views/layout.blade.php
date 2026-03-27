<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>QRgame</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased" x-data>
        <div class="forest-particles fixed inset-0 pointer-events-none z-0"></div>

        <div class="relative z-10 max-w-md mx-auto min-h-screen flex flex-col">
            {{-- Header --}}
            <header class="game-card rounded-none border-x-0 border-t-0 backdrop-forest sticky top-0 z-50">
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-extrabold tracking-tight text-forest-green" style="color: var(--color-forest-green);">
                            ⚡ QRgame
                        </span>
                    </div>
                    <div class="text-sm font-semibold" style="color: var(--color-forest-muted);">
                        @yield('title')
                    </div>
                </div>

                @hasSection('team_name')
                <div class="flex items-center justify-between px-5 py-2 border-t" style="border-color: var(--color-forest-border);"
                     x-data="liveScore({{ session('team_id', 0) }}, {{ (int) View::yieldContent('team_score', 0) }})">
                    <div class="text-sm font-semibold" style="color: var(--color-forest-light);">
                        @yield('team_name')
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-sm font-bold tabular-nums" style="color: var(--color-forest-green);"
                              x-text="score + ' punten'"
                              x-transition>
                            @yield('team_score', '0') punten
                        </span>
                        <template x-if="delta !== 0">
                            <span class="score-float text-xs font-bold"
                                  :class="delta > 0 ? 'text-green-400' : 'text-red-400'"
                                  x-text="(delta > 0 ? '+' : '') + delta"></span>
                        </template>
                    </div>
                </div>
                @endif
            </header>

            {{-- Content --}}
            <main class="flex-1 flex flex-col items-center justify-center px-5 py-8 relative"
                  x-data="pageTransition()"
                  x-init="enter()"
                  :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                  style="transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="text-center py-4 text-xs" style="color: var(--color-forest-muted);">
                SD QRgame
            </footer>
        </div>
    </body>
</html>
