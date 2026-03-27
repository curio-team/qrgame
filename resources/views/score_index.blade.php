@extends('layout')

@section('title', '🏆 Scorebord')

@section('content')
<div class="w-full space-y-6 text-center">
    <div class="text-5xl mb-2">🏆</div>
    <h1 class="text-2xl font-extrabold" style="color: var(--color-forest-light);">Kies een spel</h1>

    <div class="space-y-3">
        @foreach ($games as $game)
        <a href="/scores/game/{{ $game->id }}"
           class="game-card block p-5 rounded-xl no-underline transition-all duration-200 hover:scale-[1.02] active:scale-95"
           style="border-color: var(--color-forest-border);">
            <div class="flex items-center justify-between">
                <span class="text-base font-bold" style="color: var(--color-forest-light);">{{ $game->name }}</span>
                <span class="text-xs px-2 py-1 rounded-full" style="background: rgba(34,197,94,0.15); color: var(--color-forest-green);">#{{ $game->id }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection