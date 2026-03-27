@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')
<div class="text-center space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100">
        <div class="text-6xl mb-4">😵</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-cursed);">Helaas...</h1>
    </div>
    <div x-show="show" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="game-card p-6 rounded-xl" style="border-color: var(--color-rarity-cursed);">
            <p class="font-semibold" style="color: var(--color-forest-light);">{{ $msg }}</p>
        </div>
    </div>
    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm">← Terug naar home</a>
</div>
@endsection