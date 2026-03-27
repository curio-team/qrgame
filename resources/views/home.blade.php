@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')
<div class="text-center space-y-8 w-full" x-data="{ ready: false }" x-init="setTimeout(() => ready = true, 100)">
    {{-- Animated welcome --}}
    <div x-show="ready" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 -translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
        <h1 class="text-3xl font-extrabold mb-2" style="color: var(--color-forest-light);">Welkom! 👋</h1>
        <p class="text-sm" style="color: var(--color-forest-muted);">Je bent ingelogd als <strong style="color: var(--color-forest-green);">{{ $team->name }}</strong></p>
    </div>

    {{-- QR scan indicator --}}
    <div x-show="ready" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
         class="mx-auto w-32 h-32 rounded-2xl flex items-center justify-center scan-pulse" style="background: var(--color-forest-card); border: 2px solid var(--color-forest-border);">
        <span class="text-5xl">📱</span>
    </div>

    <div x-show="ready" x-transition:enter="transition ease-out duration-500 delay-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <p class="text-lg font-semibold" style="color: var(--color-forest-light);">Scan een QR-code om te beginnen</p>
        <p class="text-xs mt-2" style="color: var(--color-forest-muted);">Richt je camera op een QR-code in het speelveld</p>
    </div>
</div>
@endsection