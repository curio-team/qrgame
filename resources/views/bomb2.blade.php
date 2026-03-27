@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🛡️ Immuun')

@section('content')
<div class="w-full text-center space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
        <div class="text-7xl mb-2">🛡️</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-forest-green);">Immuun!</h1>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card game-card-glow p-6 rounded-xl">
            <p class="text-base font-semibold" style="color: var(--color-forest-light);">Je hebt al 6 bommen gescand!</p>
            <p class="text-sm mt-2" style="color: var(--color-forest-green);">Je bent nu <strong>immuun</strong> — er gaan geen punten meer af 🎉</p>
        </div>
    </div>

    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm">← Terug</a>
</div>
@endsection