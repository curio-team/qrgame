@extends('layout')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-sm mx-auto space-y-8" x-data="{ loading: false }">
    <div class="text-center">
        <div class="text-5xl mb-4">🎮</div>
        <h1 class="text-2xl font-extrabold" style="color: var(--color-forest-light);">QR Game</h1>
        <p class="text-sm mt-1" style="color: var(--color-forest-muted);">Voer je teamcode in om te beginnen</p>
    </div>

    <form method="POST" action="/login" @submit="loading = true" class="space-y-4">
        @csrf
        <div class="game-card p-1 rounded-xl">
            <input type="text" name="code" required autofocus placeholder="Teamcode..."
                   class="w-full px-4 py-3 rounded-lg text-center text-lg font-bold tracking-widest border-0 outline-none"
                   style="background: var(--color-forest-dark); color: var(--color-forest-light); caret-color: var(--color-forest-green);" />
        </div>

        <button type="submit" class="btn-primary w-full text-lg py-4 rounded-xl" :class="loading && 'opacity-60 pointer-events-none'">
            <span x-show="!loading">🚀 Inloggen</span>
            <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Laden...
            </span>
        </button>
    </form>

    @if($errors->any())
    <div class="game-card p-4 rounded-xl text-center" style="border-color: var(--color-rarity-cursed);">
        <p class="text-sm font-semibold" style="color: var(--color-rarity-cursed);">❌ Ongeldige teamcode</p>
    </div>
    @endif
</div>
@endsection