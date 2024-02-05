@extends('layout')

@section('body')
    <div class="client">
        <div class="client-info">
            <p><b>Client # </b>{{ $client->id }}</p>
            <div>
                <div>
                    <p>Name: </p>
                    <p>Surname: </p>
                </div>
                <div>
                    <p>{{ $client->name }}</p>
                    <p>{{ $client->surname }}</p>
                </div>
            </div>
            <div>
                <button class="button" id="edit">
                    <span>
                        <a href="{{ route('clients-edit', $client) }} ">Edit</a>
                    </span>
                </button>
                <button class="button" id="go-back">
                    <span>
                        <a href="{{ route('clients-accounts.page', ['page' => $page]) }}"> Go back</a>
                    </span>
                </button>
            </div>
        </div>
        <div class="client-info show-details">
            <p><b> Client accounts and balance </b></p>
            <table class="table table-success table-striped show-acc">
                <thead>
                    <tr>
                        <th>Iban
                        </th>
                        <th>Balance
                        </th>
                        <th colspan="3">Controls
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>LT45 1674 1684 1354 3241</td>
                        <td> 30000000 EUR</td>
                        <td>
                            <button class="ctrl-button ctrl-button-plus">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">+</a>
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="ctrl-button ctrl-button-minus">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">-</a>
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="ctrl-button ctrl-button-delete">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">x</a>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>LT45 1674 1684 1354 3241</td>
                        <td> 70000 EUR</td>
                        <td>
                            <button class="ctrl-button ctrl-button-plus">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">+</a>
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="ctrl-button ctrl-button-minus">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">-</a>
                                </span>
                            </button>
                        </td>
                        <td>
                            <button class="ctrl-button ctrl-button-delete">
                                <span>
                                    <a href="{{ route('clients-edit', $client) }} ">x</a>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Create new account: </td>
                        <td colspan="4">
                            <button class="ctrl-button ctrl-button-create">
                                <span>
                                    <a href="#">Create</a>
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total balance: </td>
                        <td> 100000 EUR</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
