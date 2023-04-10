@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Vlag-challenge</h1>
<p>Verdien punten door minsten <strong>3 teamleden</strong> te verzamelen bij deze vlag binnen <strong>5 minuten</strong>. De teamleden moeten allemaal de QR van deze vlag scannen.</p>

<img src="/img/flag-open.png" alt="vlag" width="100" style="margin: 40px;" /></a>

<div style="background: lightblue; padding: 10px;">
    <p><strong>Stand:</strong></p>
    <p>{{ count($answer->scans) }} scans</p>
    <p>Nog {{ $time }}</p>
</div>

@endsection