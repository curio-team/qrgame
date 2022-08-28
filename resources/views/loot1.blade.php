@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Spannend!</h1>
<p>Deze <em>loot box</em> kan punten opleveren voor je team! Maar het kan ook niets opleveren, of zelfs punten kosten... Durf jij het aan? Ieder team kan deze box maar één keer activeren! Druk op de afbeelding en kijk wat het jullie oplevert!</p>

<a href="/loot/{{$question->slug}}"><img src="/img/loot-closed.png" alt="lootbox" width="200" style="margin: 20px;" /></a>

@endsection