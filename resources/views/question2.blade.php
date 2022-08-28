@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

@if(isset($stale))
    <div style="background: rgba(174,174,174,0.75);
    position: absolute;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 30px;
    font-size: 50px;
    font-weight: bold;
    font-family: monospace;"><p>CODE AL GESCAND</p></div>
@endif

<h1 style="text-decoration: underline; margin-bottom: 30px;">{{ $answer->points }} punten</h1>
<p><strong>{{ $question->text }}</strong></p>
<p style="background: {{ ($question->correct_answer == 'a') ? 'lightgreen' : (($answer->answer_given == 'a') ? 'darkgray' : 'whitesmoke') }}; padding: 10px; margin: 10px 0; min-width: 50%"><strong>A</strong> {{ $question->answer_a }}</p>
<p style="background: {{ ($question->correct_answer == 'b') ? 'lightgreen' : (($answer->answer_given == 'b') ? 'darkgray' : 'whitesmoke') }}; padding: 10px; margin: 10px 0; min-width: 50%"><strong>B</strong> {{ $question->answer_b }}</p>
<p style="background: {{ ($question->correct_answer == 'c') ? 'lightgreen' : (($answer->answer_given == 'c') ? 'darkgray' : 'whitesmoke') }}; padding: 10px; margin: 10px 0; min-width: 50%"><strong>C</strong> {{ $question->answer_c }}</p>

@endsection