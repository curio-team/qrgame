@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🎁 Loot Box')

@section('content')
<div class="w-full text-center space-y-6" x-data="encounterReveal('epic')">
    {{-- Suspense phase --}}
    <div x-show="phase !== 'loading'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="text-4xl mb-2">🎁</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-epic);">Loot Box!</h1>
    </div>

    <div x-show="phase === 'reveal' || phase === 'result'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-6 rounded-xl glow-epic" style="border-color: var(--color-rarity-epic);">
            <p class="text-sm mb-4" style="color: var(--color-forest-light);">Deze loot box kan punten opleveren voor je team! Maar het kan ook punten kosten... Durf jij het aan?</p>
            <p class="text-xs mb-6" style="color: var(--color-forest-muted);">⚡ Ieder team kan deze box maar één keer activeren!</p>

            <a href="/loot/{{$question->slug}}" class="btn-primary text-lg py-4 px-8 rounded-xl inline-flex scan-pulse">
                🎲 Open de Loot Box!
            </a>
        </div>
    </div>

    {{-- Loading --}}
    <div x-show="phase === 'loading'" class="flex justify-center py-12">
        <svg class="animate-spin h-8 w-8" style="color: var(--color-rarity-epic);" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
    </div>
</div>
@endsection