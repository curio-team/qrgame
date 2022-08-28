@extends('layout')

@section('team_name', $team->name)
@section('team_score', $team->score)

@section('content')

<h1>Helaas...</h1>
<p>{{  $msg }}</p>

@endsection