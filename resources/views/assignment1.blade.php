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

<h1>Opdracht</h1>
<p>Klik op de afbeelding op deze opdracht te onthullen. Maar let op: zodra je klikt, ben jij de enige die deze opdracht kan zien! <em>Jij</em> moet dus zorgen dat de opdracht wordt uitgevoerd door je team.</p>

<a href="/assignment/{{$question->slug}}"><img src="/img/keyhole.png" alt="sleutelgat" width="200" style="margin: 20px;" /></a>

@endsection