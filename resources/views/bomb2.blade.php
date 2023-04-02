@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Oei!</h1>
<img src="/img/bomb.png" alt="bom" width="140" />
<br />
<p>Je hebt al 6 bommen gescand, je bent nu <strong>immuun</strong>!</p>
<p>Er gaan geen punten meer af.</p>
<br />
@endsection