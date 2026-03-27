@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', '🏳️ Vlag')

@section('content')
<div class="w-full text-center space-y-6" x-data="{ progress: {{ count($answer->scans) }}, target: 3 }">
    <div class="text-5xl mb-2">🏳️</div>
    <h1 class="text-2xl font-extrabold" style="color: var(--color-rarity-rare);">Vlag-challenge</h1>

    <div class="game-card p-6 rounded-xl glow-rare" style="border-color: var(--color-rarity-rare);">
        <p class="text-sm mb-4" style="color: var(--color-forest-light);">Verdien punten door minstens <strong style="color: var(--color-rarity-rare);">3 teamleden</strong> te verzamelen bij deze vlag binnen <strong style="color: var(--color-rarity-rare);">5 minuten</strong>.</p>
        <p class="text-xs" style="color: var(--color-forest-muted);">De teamleden moeten allemaal de QR van deze vlag scannen.</p>
    </div>

    {{-- Progress --}}
    <div class="game-card p-5 rounded-xl space-y-4">
        <p class="text-sm font-semibold" style="color: var(--color-forest-muted);">Voortgang</p>

        {{-- Progress bar --}}
        <div class="w-full h-4 rounded-full overflow-hidden" style="background: var(--color-forest-dark);">
            <div class="h-full rounded-full transition-all duration-1000 ease-out"
                 style="width: {{ min(100, (count($answer->scans) / 3) * 100) }}%; background: linear-gradient(90deg, var(--color-rarity-rare), var(--color-forest-green));"></div>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-2xl font-extrabold" style="color: var(--color-rarity-rare);">
                {{ count($answer->scans) }} / 3 scans
            </span>
            <span class="text-sm font-semibold px-3 py-1 rounded-full" style="background: rgba(96,165,250,0.15); color: var(--color-rarity-rare);">
                ⏰ Nog {{ $time }}
            </span>
        </div>
    </div>

    <p class="text-xs" style="color: var(--color-forest-muted);">Laat je teamleden deze QR-code scannen!</p>
</div>
@endsection