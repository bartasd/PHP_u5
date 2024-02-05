@extends('layout')

@section('body')
    <div class="containerForm">
        <form action="{{ route('clients-update', $client) }}" method="post">
            <p>You're editing clients #{{ $client->id }} info</p>
            <p>{{ $client->name }} {{ $client->surname }}</p>
            <input type="text" placeholder="Name" name="name" required><br>
            <input type="text" placeholder="Surname"name="surname" required><br>
            <input type="submit" value="Update">
            @csrf
        </form>
    </div>
@endsection
