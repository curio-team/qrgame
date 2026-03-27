@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)
@section('title', 'Resultaat')

@section('content')
<div class="w-full space-y-6 text-center relative" x-data="{ show: false{{ $answer->points > 0 ? ", showConfetti: true" : '' }} }" x-init="setTimeout(() => show = true, 100)">

    @if(isset($stale))
    <div class="absolute inset-0 z-40 rounded-2xl flex items-center justify-center backdrop-forest">
        <span class="text-2xl font-extrabold tracking-wider" style="color: var(--color-rarity-cursed);">🔒 CODE AL GESCAND</span>
    </div>
    @endif

    {{-- Points result --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
         class="inline-block">
        <div class="text-5xl font-extrabold mb-1" style="color: {{ $answer->points > 0 ? 'var(--color-forest-green)' : 'var(--color-rarity-cursed)' }};" x-data="scoreCounter(0, {{ $answer->points }})" x-text="displayValue + ' punten'">{{ $answer->points }} punten</div>
        <p class="text-sm" style="color: var(--color-forest-muted);">{{ $answer->points > 0 ? '🎉 Goed gedaan!' : '😔 Helaas, fout antwoord' }}</p>
    </div>

    {{-- Question --}}
    <div class="game-card p-5 rounded-xl">
        <p class="text-base font-semibold" style="color: var(--color-forest-light);">{{ $question->text }}</p>
    </div>

    {{-- Answer review --}}
    <div class="space-y-3">
        @foreach(['a' => $question->answer_a, 'b' => $question->answer_b, 'c' => $question->answer_c] as $key => $text)
        @php
            $isCorrect = strcasecmp($question->correct_answer, $key) === 0;
            $isGiven = strcasecmp($answer->answer_given ?? '', $key) === 0;
            $bg = $isCorrect ? 'rgba(34,197,94,0.2)' : ($isGiven ? 'rgba(248,113,113,0.2)' : 'var(--color-forest-card)');
            $border = $isCorrect ? 'rgba(34,197,94,0.5)' : ($isGiven ? 'rgba(248,113,113,0.5)' : 'var(--color-forest-border)');
            $icon = $isCorrect ? '✅' : ($isGiven && !$isCorrect ? '❌' : '');
        @endphp
        <div class="game-card p-4 rounded-xl flex items-center gap-3" style="background: {{ $bg }}; border-color: {{ $border }};">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold"
                  style="background: rgba(255,255,255,0.1); color: var(--color-forest-light);">
                {{ strtoupper($key) }}
            </span>
            <span class="text-sm font-semibold text-left flex-1" style="color: var(--color-forest-light);">{{ $text }}</span>
            @if($icon)<span class="text-lg">{{ $icon }}</span>@endif
        </div>
        @endforeach
    </div>

    <a href="/" class="btn-ghost inline-flex px-6 py-3 rounded-xl text-sm">← Terug</a>
</div>
@endsection