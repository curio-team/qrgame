@extends('layout')

@section('content')

    <h1>{{ $game->name }}</h1>
    <p>Punt toevoegen</p>
    <form action="/points/add/game/{{ $game->id }}" style="font-size: 30px;" method="POST">
        @csrf
        <select name="team" style="font-size: 24px; width: 200px;">
            @foreach ($game->teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select><br />
        <input type="number" placeholder="Aantal punten" name="points" style="font-size: 24px; width: 200px;"><br />
        <input type="submit" value="Toekennen" style="font-size: 24px; width: 200px;"><br />
    </form>

@endsection