@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', 'Home')

@section('content')
<div class="text-center space-y-6 w-full" x-data="homeScanner()">
    {{-- Animated welcome --}}
    <div x-show="ready" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 -translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
        <h1 class="text-3xl font-extrabold mb-2" style="color: var(--color-forest-light);">Welkom! 👋</h1>
        <p class="text-sm" style="color: var(--color-forest-muted);">Je bent ingelogd als <strong style="color: var(--color-forest-green);">{{ $team->name }}</strong></p>
    </div>

    <div x-show="ready" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
         class="mx-auto w-full max-w-xs game-card rounded-2xl p-3" style="border-color: var(--color-forest-border);">
        <div class="relative overflow-hidden rounded-xl" style="background: var(--color-forest-dark); min-height: 220px;">
            <video x-ref="scannerVideo" x-show="scanning" class="w-full h-[220px] object-cover" autoplay muted playsinline></video>

            <div x-show="!scanning" class="absolute inset-0 flex items-center justify-center">
                <div class="w-28 h-28 rounded-2xl flex items-center justify-center scan-pulse" style="background: var(--color-forest-card); border: 2px solid var(--color-forest-border);">
                    <span class="text-5xl">📷</span>
                </div>
            </div>
        </div>

        <div class="mt-3 text-xs font-semibold" style="color: var(--color-forest-muted);" x-text="status"></div>

        <p x-show="error" class="mt-2 text-xs font-semibold" style="color: var(--color-rarity-cursed);" x-text="error"></p>

        <div class="mt-4 flex items-center justify-center gap-3">
            <button type="button" x-show="!scanning" @click="startScanner()" class="btn-primary px-4 py-2 rounded-lg text-sm">
                Start scanner
            </button>
            <button type="button" x-show="scanning" @click="stopScanner()" class="px-4 py-2 rounded-lg text-sm font-semibold" style="background: var(--color-forest-card); border: 1px solid var(--color-forest-border); color: var(--color-forest-light);">
                Stop scanner
            </button>
        </div>
    </div>

    <div x-show="ready" x-transition:enter="transition ease-out duration-500 delay-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <p class="text-lg font-semibold" style="color: var(--color-forest-light);">Scan direct vanuit deze pagina</p>
        <p class="text-xs mt-2" style="color: var(--color-forest-muted);">Je hoeft de app niet meer te sluiten of opnieuw te openen.</p>
    </div>
</div>
@endsection
