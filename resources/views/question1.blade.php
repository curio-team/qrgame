@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', 'Vraag')

@section('content')
<div class="w-full space-y-6 text-center" x-data="encounterReveal('rare')">
    {{-- Question text --}}
    <div x-show="phase !== 'loading'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="text-4xl mb-3">❓</div>
        <h1 class="text-xl font-extrabold mb-4" style="color: var(--color-forest-light);">Vraag</h1>
        <div class="game-card p-5 rounded-xl mb-6">
            <p class="text-base font-semibold" style="color: var(--color-forest-light);">{{ $question->text }}</p>
        </div>
    </div>

    {{-- Answer options --}}
    <div x-show="phase === 'result' || phase === 'reveal'" class="space-y-3">
        @foreach(['a' => $question->answer_a, 'b' => $question->answer_b, 'c' => $question->answer_c] as $key => $text)
        <a href="/question/{{ $question->slug }}/{{ $key }}"
           class="game-card block p-4 rounded-xl no-underline transition-all duration-200 hover:scale-[1.02] active:scale-95"
           style="border-color: var(--color-forest-border);"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-x-4"
           x-transition:enter-end="opacity-100 translate-x-0"
           :style="{ transitionDelay: '{{ $loop->index * 100 }}ms' }">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold"
                      style="background: rgba(34,197,94,0.15); color: var(--color-forest-green);">
                    {{ strtoupper($key) }}
                </span>
                <span class="text-sm font-semibold text-left" style="color: var(--color-forest-light);">{{ $text }}</span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Loading spinner --}}
    <div x-show="phase === 'loading'" class="flex justify-center py-12">
        <svg class="animate-spin h-8 w-8" style="color: var(--color-forest-green);" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
    </div>
</div>
@endsection