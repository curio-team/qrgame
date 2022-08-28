@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Vraag</h1>
<p><strong>{{ $question->text }}</strong></p>
<p style="background: whitesmoke; padding: 10px; margin: 10px 0; min-width: 50%"><a style="text-decoration: none;" href="/question/{{ $question->slug }}/a"><strong>A</strong> {{ $question->answer_a }}</a></p>
<p style="background: whitesmoke; padding: 10px; margin: 10px 0; min-width: 50%"><a style="text-decoration: none;" href="/question/{{ $question->slug }}/b"><strong>B</strong> {{ $question->answer_b }}</a></p>
<p style="background: whitesmoke; padding: 10px; margin: 10px 0; min-width: 50%"><a style="text-decoration: none;" href="/question/{{ $question->slug }}/c"><strong>C</strong> {{ $question->answer_c }}</a></p>

@endsection