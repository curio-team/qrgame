@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🔐 Opdracht')

@section('content')
<div class="w-full text-center space-y-6 relative" x-data="encounterReveal('rare')">

    @if(isset($stale))
    <div class="absolute inset-0 z-40 rounded-2xl flex items-center justify-center backdrop-forest">
        <span class="text-2xl font-extrabold tracking-wider" style="color: var(--color-rarity-cursed);">🔒 CODE AL GESCAND</span>
    </div>
    @endif

    <div x-show="phase !== 'loading'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="text-5xl mb-2">🔐</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-rare);">Geheime Opdracht</h1>
    </div>

    <div x-show="phase === 'reveal' || phase === 'result'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-6 rounded-xl glow-rare" style="border-color: var(--color-rarity-rare);">
            <p class="text-sm mb-4" style="color: var(--color-forest-light);">Klik op de knop om deze opdracht te onthullen.</p>
            <p class="text-xs mb-6" style="color: var(--color-rarity-cursed);">⚠️ Let op: zodra je klikt, ben <strong>jij</strong> de enige die deze opdracht kan zien!</p>

            <a href="/assignment/{{$question->slug}}" class="btn-primary text-lg py-4 px-8 rounded-xl inline-flex scan-pulse">
                🔓 Onthul de Opdracht
            </a>
        </div>
    </div>

    <div x-show="phase === 'loading'" class="flex justify-center py-12">
        <svg class="animate-spin h-8 w-8" style="color: var(--color-rarity-rare);" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
    </div>
</div>
@endsection