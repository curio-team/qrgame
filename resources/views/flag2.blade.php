@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🏳️ Resultaat')

@section('content')
<div class="w-full text-center space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100">
        <div class="text-5xl mb-2">{{ $answer->points > 0 ? '🏆' : '🏳️' }}</div>
        <h1 class="text-2xl font-extrabold" style="color: {{ $answer->points > 0 ? 'var(--color-forest-green)' : 'var(--color-forest-muted)' }};">Vlag-challenge afgelopen</h1>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-6 rounded-xl {{ $answer->points > 0 ? 'game-card-glow' : '' }}">
            <div class="flex justify-around items-center">
                <div>
                    <p class="text-sm" style="color: var(--color-forest-muted);">Scans</p>
                    <p class="text-3xl font-extrabold" style="color: var(--color-rarity-rare);">{{ count($answer->scans ?? []) }}</p>
                </div>
                <div class="w-px h-12" style="background: var(--color-forest-border);"></div>
                <div>
                    <p class="text-sm" style="color: var(--color-forest-muted);">Punten</p>
                    <p class="text-3xl font-extrabold" style="color: {{ $answer->points > 0 ? 'var(--color-forest-green)' : 'var(--color-forest-muted)' }};" x-data="scoreCounter(0, {{ $answer->points }})" x-text="displayValue">{{ $answer->points }}</p>
                </div>
            </div>
        </div>
    </div>

    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm">← Terug</a>
</div>
@endsection