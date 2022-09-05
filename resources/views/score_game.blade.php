@extends('layout')

@section('content')

    @foreach ($teams as $team)
        {{ $team->name }}, {{ $team->score }}
    @endforeach

@endsection