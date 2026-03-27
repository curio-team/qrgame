@extends('layout')

@section('title', '➕ Punten')

@section('content')
<div class="w-full max-w-sm mx-auto space-y-6" x-data="{ submitted: false }">
    <div class="text-center">
        <h1 class="text-xl font-extrabold" style="color: var(--color-forest-light);">{{ $game->name }}</h1>
        <p class="text-sm" style="color: var(--color-forest-muted);">Punt toevoegen</p>
    </div>

    <form action="/points/add/game/{{ $game->id }}" method="POST" @submit="submitted = true" class="space-y-4">
        @csrf
        <div class="game-card p-1 rounded-xl">
            <select name="team" class="w-full px-4 py-3 rounded-lg border-0 outline-none text-base font-semibold" style="background: var(--color-forest-dark); color: var(--color-forest-light);">
                @foreach ($game->teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="game-card p-1 rounded-xl">
            <input type="number" placeholder="Aantal punten" name="points" required
                   class="w-full px-4 py-3 rounded-lg border-0 outline-none text-base font-semibold text-center"
                   style="background: var(--color-forest-dark); color: var(--color-forest-light); caret-color: var(--color-forest-green);" />
        </div>

        <button type="submit" class="btn-primary w-full py-4 rounded-xl text-base" :class="submitted && 'opacity-60 pointer-events-none'">
            <span x-show="!submitted">✅ Toekennen</span>
            <span x-show="submitted" x-cloak>Opslaan...</span>
        </button>
    </form>
</div>
@endsection