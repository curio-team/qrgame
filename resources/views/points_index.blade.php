@extends('layout')

@section('content')

    @foreach ($games as $game)
        <a href="/points/add/game/{{ $game->id }}">{{ $game->name }} (#{{ $game->id }})</a>
    @endforeach

@endsection