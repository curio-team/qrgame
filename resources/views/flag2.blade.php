@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Vlag-challenge</h1>
<p>Deze challenge is afgelopen.</p>

<img src="/img/flag-closed.png" alt="vlag" width="100" style="margin: 40px;" /></a>

<div style="background: lightblue; padding: 10px;">
    <p><strong>Stand:</strong></p>
    <p>{{ count($answer->scans) }} scans</p>
    <p><strong style="text-decoration: underline;">{{ $answer->points }} punten</strong></p>
</div>

@endsection