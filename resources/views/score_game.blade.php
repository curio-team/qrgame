
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>QRgame — Scorebord</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased" style="background-color: var(--color-forest-deep); color: var(--color-forest-light);">
        <div class="forest-particles fixed inset-0 pointer-events-none z-0"></div>

        <div class="relative z-10 max-w-2xl mx-auto min-h-screen flex flex-col"
             x-data="liveLeaderboard({{ $game->id }}, {{ json_encode($teams) }})"
             x-init="startPolling()">

            {{-- Header --}}
            <header class="text-center py-6 sticky top-0 z-50 backdrop-forest">
                <h1 class="text-3xl font-black tracking-tight" style="color: var(--color-forest-green);">🏆 {{ $game->name }}</h1>
                <p class="text-sm mt-1" style="color: var(--color-forest-muted);">
                    Live scorebord
                    <span class="inline-block w-2 h-2 rounded-full ml-1 animate-pulse" style="background: var(--color-forest-green);"></span>
                </p>
            </header>

            {{-- Podium top 3 --}}
            <div class="flex items-end justify-center gap-3 px-4 py-6" x-show="teams.length >= 3">
                {{-- 2nd place --}}
                <div class="flex-1 text-center transition-all duration-500"
                     x-show="teams[1]"
                     x-transition:enter="transition ease-out duration-500 delay-200"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="game-card podium-2 p-4 rounded-xl">
                        <div class="text-3xl mb-1">🥈</div>
                        <p class="text-sm font-bold truncate" x-text="teams[1]?.name" style="color: var(--color-forest-light);"></p>
                        <p class="text-2xl font-black score-number" style="color: #94a3b8;" x-text="teams[1]?.score + ' pt'"></p>
                    </div>
                    <div class="h-16 rounded-b-lg mt-1" style="background: linear-gradient(to bottom, rgba(148,163,184,0.2), transparent);"></div>
                </div>

                {{-- 1st place --}}
                <div class="flex-1 text-center transition-all duration-500"
                     x-show="teams[0]"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="game-card podium-1 p-5 rounded-xl game-card-glow">
                        <div class="text-4xl mb-1">🥇</div>
                        <p class="text-base font-bold truncate" x-text="teams[0]?.name" style="color: var(--color-forest-light);"></p>
                        <p class="text-3xl font-black score-number" style="color: #fbbf24;" x-text="teams[0]?.score + ' pt'"></p>
                    </div>
                    <div class="h-24 rounded-b-lg mt-1" style="background: linear-gradient(to bottom, rgba(251,191,36,0.2), transparent);"></div>
                </div>

                {{-- 3rd place --}}
                <div class="flex-1 text-center transition-all duration-500"
                     x-show="teams[2]"
                     x-transition:enter="transition ease-out duration-500 delay-400"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="game-card podium-3 p-4 rounded-xl">
                        <div class="text-3xl mb-1">🥉</div>
                        <p class="text-sm font-bold truncate" x-text="teams[2]?.name" style="color: var(--color-forest-light);"></p>
                        <p class="text-2xl font-black score-number" style="color: #cd7f32;" x-text="teams[2]?.score + ' pt'"></p>
                    </div>
                    <div class="h-10 rounded-b-lg mt-1" style="background: linear-gradient(to bottom, rgba(205,127,50,0.2), transparent);"></div>
                </div>
            </div>

            {{-- Full ranking list --}}
            <div class="flex-1 px-4 pb-8 space-y-2">
                <template x-for="(team, index) in teams" :key="team.id">
                    <div class="score-row game-card p-4 rounded-xl flex items-center gap-4"
                         :class="team.rankChanged && 'rank-changed'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0">

                        {{-- Rank number --}}
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-black"
                             :style="index === 0 ? 'background: rgba(251,191,36,0.2); color: #fbbf24;' :
                                     index === 1 ? 'background: rgba(148,163,184,0.2); color: #94a3b8;' :
                                     index === 2 ? 'background: rgba(205,127,50,0.2); color: #cd7f32;' :
                                     'background: rgba(107,127,150,0.15); color: var(--color-forest-muted);'"
                             x-text="index + 1">
                        </div>

                        {{-- Team name --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold truncate" style="color: var(--color-forest-light);" x-text="team.name"></p>
                        </div>

                        {{-- Rank delta --}}
                        <template x-if="team.rankDelta > 0">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background: rgba(34,197,94,0.15); color: var(--color-forest-green);" x-text="'▲' + team.rankDelta"></span>
                        </template>
                        <template x-if="team.rankDelta < 0">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full" style="background: rgba(248,113,113,0.15); color: var(--color-rarity-cursed);" x-text="'▼' + Math.abs(team.rankDelta)"></span>
                        </template>

                        {{-- Score --}}
                        <div class="text-right">
                            <span class="text-lg font-black score-number" style="color: var(--color-forest-green);" x-text="team.score + ' pt'"></span>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Footer --}}
            <footer class="text-center py-4 text-xs" style="color: var(--color-forest-muted);">
                Auto-updates elke 3 seconden • SD QRgame
            </footer>
        </div>
    </body>
</html>
