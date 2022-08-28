@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Opdracht</h1>
<p>Klik op de afbeelding op deze opdracht te onthullen. Maar let op: zodra je klikt, ben jij de enige die deze opdracht kan zien! <em>Jij</em> moet dus zorgen dat de opdracht wordt uitgevoerd door je team.</p>

<a href="/assignment/{{$question->slug}}"><img src="/img/keyhole.png" alt="sleutelgat" width="200" style="margin: 20px;" /></a>

@endsection