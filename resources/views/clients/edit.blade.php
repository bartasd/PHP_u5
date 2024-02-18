@extends('layout')

@section('body')
    <div class="containerForm statisticsForm">
        <div class="client-info transfer add-box">
            <form class="reset add-form" action="{{ route('clients-update', ['client' => $client, 'page' => $page]) }}"
                method="post">
                <h1>You're editing clients #{{ $client->id }} info</h1>
                <h2>{{ $client->name }} {{ $client->surname }}</h2>
                <input type="text" placeholder="Name" name="name" required><br>
                <input type="text" placeholder="Surname"name="surname" required><br>
                @csrf
                <div class="some-buttons">
                    <button type="submit" class="button" id="transfer">
                        <span>Update</span>
                    </button>
                    <button class="button" id="go-back">
                        <span>
                            <a href="{{ route('clients-show', ['client' => $client, 'page' => $page]) }}"> Go back</a>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
