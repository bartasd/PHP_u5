@extends('layout')

@section('body')
    <div class="containerForm">
        <form action="{{ route('clients-update', ['client' => $client, 'page' => $page]) }}" method="post">
            <p>You're editing clients #{{ $client->id }} info</p>
            <p>{{ $client->name }} {{ $client->surname }}</p>
            <input type="text" placeholder="Name" name="name" required><br>
            <input type="text" placeholder="Surname"name="surname" required><br>
            <input type="submit" value="Update">
            @csrf
            <button class="button" id="go-back">
                <span>
                    <a href="{{ route('clients-show', ['client' => $client, 'page' => $page]) }}"> Go back</a>
                </span>
            </button>
        </form>
    </div>
@endsection
