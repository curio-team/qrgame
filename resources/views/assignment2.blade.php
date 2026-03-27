@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '📝 Opdracht')

@section('content')
<div class="w-full text-center space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
        <div class="text-5xl mb-2">📝</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-rare);">Opdracht onthuld!</h1>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-4 rounded-xl mb-4" style="border-color: var(--color-rarity-cursed);">
            <p class="text-xs font-semibold" style="color: var(--color-rarity-cursed);">⚠️ Als je deze pagina ververst of afsluit verdwijnt de opdracht. Jij bent de enige die deze kan zien!</p>
        </div>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-400" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-6 rounded-xl glow-rare" style="border-color: var(--color-rarity-rare);">
            <p class="text-lg font-bold mb-4" style="color: var(--color-forest-light);">{{ $question->text }}</p>
            <div class="w-full h-px my-4" style="background: var(--color-forest-border);"></div>
            <p class="text-sm" style="color: var(--color-forest-muted);">Leg het resultaat vast op foto of film en laat dat zien aan de jury, of doe de opdracht live bij de jury.</p>
        </div>
    </div>
</div>
@endsection