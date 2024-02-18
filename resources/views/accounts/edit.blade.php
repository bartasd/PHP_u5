@extends('layout')

@section('body')
    <p> ACCOUNTS EDIT PAGE </p>
    <div class="containerForm statisticsForm">
        <div class="client-info transfer add-box">
            <form class="reset add-form"
                action="{{ route('accounts-update', ['client' => $client, 'account' => $account, 'action' => $action, 'page' => $page]) }}"
                method="post">
                <h1>You're editing clients #{{ $client->id }}</h1>
                <h2>{{ $client->name }} {{ $client->surname }} </h2>
                <h2>Account: {{ $account->iban }}</h2>
                <h2>Please enter an ammount to {{ $action == 'plus' ? 'add to' : 'take away from' }} this account.</h2>
                <input type="text" placeholder="ammount" name="ammount" required><br>
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
