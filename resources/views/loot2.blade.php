@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🎁 Resultaat')

@section('content')
<div class="w-full text-center space-y-6 relative"
     x-data="caseOpening({{ $answer->points }}, {{ $answer->points >= 4 ? "'legendary'" : ($answer->points >= 2 ? "'epic'" : ($answer->points > 0 ? "'rare'" : "'cursed'")) }})">

    @if(isset($stale))
    <div class="absolute inset-0 z-40 rounded-2xl flex items-center justify-center backdrop-forest">
        <span class="text-2xl font-extrabold tracking-wider" style="color: var(--color-rarity-cursed);">🔒 CODE AL GESCAND</span>
    </div>
    @endif

    {{-- Title --}}
    <div class="mb-2">
        <div class="text-3xl mb-1">🎁</div>
        <h1 class="text-xl font-extrabold" style="color: var(--color-rarity-epic);">Loot Box Opening</h1>
    </div>

    {{-- CSGO Case Reel --}}
    <div class="case-reel-viewport"
         :class="{ 'slowdown': phase === 'slowdown', 'reveal': phase === 'reveal' || phase === 'done' }">

        {{-- Pointer triangles --}}
        <div class="case-reel-pointer"></div>
        <div class="case-reel-pointer-bottom"></div>

        {{-- Center line --}}
        <div class="case-reel-center-line"></div>

        {{-- Fade edges --}}
        <div class="case-reel-fade-left"></div>
        <div class="case-reel-fade-right"></div>

        {{-- Scrolling reel strip --}}
        <div class="case-reel-strip"
             :style="'transform: translateX(calc(50% - 50px - ' + offset + 'px))'">
            <template x-for="(item, index) in items" :key="index">
                <div class="case-reel-item"
                     :class="{ 'winner-reveal': item.isWinner && (phase === 'reveal' || phase === 'done') }"
                     :style="'color: var(--color-rarity-' + item.rarity + ')'">
                    <span class="reel-emoji" x-text="item.emoji"></span>
                    <span class="reel-label" x-text="item.label"></span>
                    <span class="reel-points" x-text="item.points"></span>
                </div>
            </template>
        </div>
    </div>

    {{-- Spin button (only before spinning) --}}
    <div x-show="phase === 'idle'" x-transition>
        <button @click="spin()" class="btn-primary text-lg py-4 px-8 rounded-xl scan-pulse">
            🎲 Open de Loot Box!
        </button>
    </div>

    {{-- Spinning status --}}
    <div x-show="phase === 'spinning' || phase === 'slowdown'" x-transition class="text-sm font-semibold" style="color: var(--color-rarity-epic);">
        <span x-show="phase === 'spinning'">⏳ Spinning...</span>
        <span x-show="phase === 'slowdown'" class="animate-pulse">🎯 Bijna...</span>
    </div>

    {{-- Result reveal --}}
    <div x-show="showResult" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         class="case-result-reveal">
        <div class="game-card p-6 rounded-xl mt-4"
             :class="resultPoints > 0 ? 'glow-epic' : 'glow-cursed'"
             :style="'border-color: var(--color-rarity-' + resultRarity + ')'">
            <div class="text-6xl mb-3">{{ $answer->points >= 4 ? '🌟' : ($answer->points >= 2 ? '⭐' : ($answer->points > 0 ? '✨' : ($answer->points === 0 ? '🛡️' : '💀'))) }}</div>
            <div class="text-4xl font-extrabold mb-2"
                 style="color: {{ $answer->points > 0 ? 'var(--color-forest-green)' : 'var(--color-rarity-cursed)' }};"
                 x-data="scoreCounter(0, {{ $answer->points }})"
                 x-text="(displayValue > 0 ? '+' : '') + displayValue + ' punten'">
                {{ $answer->points }} punten
            </div>
            <p class="text-sm" style="color: var(--color-forest-muted);">
                {{ $answer->points >= 4 ? 'LEGENDARY! Wat een geluk! 🏆' : ($answer->points >= 2 ? 'Mooi! Lekker gescoord! 🎉' : ($answer->points > 0 ? 'Klein geluk! ✨' : ($answer->points === 0 ? 'Niets gewonnen 😐' : 'Pech gehad... 😈'))) }}
            </p>
        </div>
    </div>

    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm" x-show="showResult" x-transition>← Terug</a>
</div>
@endsection