@extends('layout')

@section('body')
    <div class="containerForm statisticsForm">
        <h1> TRANSFER PAGE</h1>
        <div class="client-info transfer">
            <form class="reset transferForm" action="{{ route('accounts-transferFunds') }}" method="post">
                <h2>Transfer From</h2>
                <select class="transferSelect" name="transferFromSelect" id="froms">
                    @foreach ($combo as $acc)
                        <option value="{{ $acc->iban }}">
                            <b>{{ $acc->client->name }} {{ $acc->client->surname }}</b>: {{ $acc->iban }}
                            <b>{{ $acc->balance }} EUR</b>
                        </option>
                    @endforeach
                </select>
                <h2>Transfer To</h2>
                <select class="transferSelect" name="transferToSelect" id="tos">
                    @foreach ($combo as $acc)
                        <option value="{{ $acc->iban }}">
                            <b>{{ $acc->client->name }} {{ $acc->client->surname }}</b>: {{ $acc->iban }}
                            <b>{{ $acc->balance }} EUR</b>
                        </option>
                    @endforeach
                </select>
                <div>
                    <input class="reset tr-input" type="text" placeholder="Enter an ammount to transfer"name="ammount"
                        required><br>
                    <button type="submit" class="button" id="transfer">
                        <span>Transfer</span>
                    </button>
                </div>

                @csrf
            </form>
        </div>
        <h2 class="taxes_title"> Deduct Taxes</h2>
        <div class="client-info transfer taxes">
            <form class="reset deductForm" action="{{ route('accounts-deductTaxes') }}" method="post">
                <div>
                    <input class="reset" type="text" placeholder="Enter an ammount to deduct"name="ammount"
                        required><br>
                    <button type="submit" class="button" id="transfer">
                        <span>Deduct</span>
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
@endsection
