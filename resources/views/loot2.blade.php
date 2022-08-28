@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Spannend!</h1>
<br>
<p>Jullie krijgen <strong>{{ $rand }} punten!</strong></p>
<br>
<img src="/img/loot-open.png" alt="lootbox" width="200" style="margin: 20px;" />

@endsection