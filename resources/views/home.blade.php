@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Welkom</h1>
<p><em>Je bent ingelogd</em></p>
<p>Scan een QR-code om te beginnen</p>

@endsection