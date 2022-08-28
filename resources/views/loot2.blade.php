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

<h1>Spannend!</h1>
<br>
<p>Jullie krijgen <strong>{{ $answer->points }} punten!</strong></p>
<br>
<img src="/img/loot-open.png" alt="lootbox" width="200" style="margin: 20px;" />

@endsection