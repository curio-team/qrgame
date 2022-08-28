@extends('layout')

@section('title', 'Login')

@section('content')

<h1>Login</h1>
<p>Voer je teamcode in:</p>

<form method="POST" action="/login">
    @csrf
    <input type="text" name="code" /><br />
    <input type="submit" value="Inloggen" >
</form>

@endsection