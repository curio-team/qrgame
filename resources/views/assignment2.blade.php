@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Opdracht</h1>
<p><em style="text-decoration: underline;">Let op:</em> als je deze pagina ververst of afsluit verdwijnt de opdracht. Jij bent de enige die deze opdracht kan zien, dus <em>jij</em> moet zorgen dat deze opdracht wordt uitgevoerd.</p>

<p style="background: lightblue; padding: 20px; margin-top: 20px;"><strong>{{ $question->text }}</strong><br><br>Leg het resultaat vast op foto of film en laat dat zien aan de jury zien, of doe de opdracht live bij de jury.</p>

@endsection