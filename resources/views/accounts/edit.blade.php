@extends('layout')

@section('body')
    <p> ACCOUNTS EDIT PAGE </p>
    <div class="containerForm account-edit">
        <form
            action="{{ route('accounts-update', ['client' => $client, 'account' => $account, 'action' => $action, 'page' => $page]) }}"
            method="post">
            <p>You're editing clients #{{ $client->id }}</p>
            <p>{{ $client->name }} {{ $client->surname }} </p>
            <p>Account: {{ $account->iban }}</p>
            <p>Please enter an ammount to {{ $action == 'plus' ? 'add to' : 'take away from' }} this account.</p>
            <input type="text" placeholder="ammount" name="ammount" required><br>
            <input type="submit" value="Update"><br>
            @csrf
            <button class="button" id="go-back">
                <span>
                    <a href="{{ route('clients-show', ['client' => $client, 'page' => $page]) }}"> Go back</a>
                </span>
            </button>
        </form>
    </div>
@endsection
