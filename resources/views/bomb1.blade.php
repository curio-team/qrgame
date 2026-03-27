@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '💣 Bom!')

@section('content')
<div class="w-full text-center space-y-6" x-data="bombEffect()" x-init="explode()">
    {{-- Bomb animation --}}
    <div :class="exploding ? 'animate-[bomb-shake_0.6s_ease]' : ''">
        <div class="text-7xl mb-2" :class="exploding && 'animate-[cursed-reveal_0.6s_ease]'">💣</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-cursed);">Oei!</h1>
    </div>

    {{-- Damage card --}}
    <div class="game-card p-6 rounded-xl glow-cursed" style="border-color: var(--color-rarity-cursed);">
        <p class="text-sm mb-3" style="color: var(--color-forest-light);">Deze QR-code ontploft in je gezicht!</p>
        <div class="text-4xl font-extrabold mb-2" style="color: var(--color-rarity-cursed);" x-data="scoreCounter(0, -{{ $rand }})" x-text="displayValue + ' punten'">-{{ $rand }} punten</div>
    </div>

    {{-- Warning --}}
    <div class="game-card p-4 rounded-xl" style="border-color: rgba(251,191,36,0.3);">
        <p class="text-xs font-semibold" style="color: var(--color-rarity-legendary);">⚠️ Let op: iedere keer dat iemand deze code scant gaan er weer opnieuw punten af!</p>
    </div>

    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm">← Terug</a>
</div>
@endsection