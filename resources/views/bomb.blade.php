@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Oei!</h1>
<img src="/img/bomb.png" alt="bom" width="140" />
<p>Deze QR-code ontploft in je gezicht!</p>
<p> Dit kost jouw team <strong>-{{ $rand }}</strong> punten.</p>
<br />
<p>let op: iedere keer dat iemand deze code scant gaan er weer opnieuw punten af!</p>

@endsection