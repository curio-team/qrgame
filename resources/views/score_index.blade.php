@extends('layout')

@section('content')

    @foreach ($games as $game)
        <a href="/scores/game/{{ $game->id }}">{{ $game->name }} (#{{ $game->id }})</a>
    @endforeach

@endsection