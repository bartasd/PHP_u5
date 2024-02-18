@extends('layout')
{{-- takes account, action, ammount --}}
@section('body')
    @if ($type == 'tax')
        <div class="containerForm statisticsForm modal-div">
            <h1> Do you really want to TAX clients with: </h1>
            <p><span>{{ $tax }}</span> EUR</p></br>
            <div class="client-info transfer transfer-modal">
                <form class="reset" action="{{ route('accounts-deductTaxes') }}" method="post">
                    <input type="hidden" name="ammount" value="{{ $tax }}">
                    <input type="hidden" name="byPass" value="true">
                    <button type="submit" class="button modal-btn modal-btn-yes" id="delete"><span>YES</span></button>
                    @csrf
                </form>
                <button class="button modal-btn modal-btn-no" id="go-back">
                    <span>
                        <a href="{{ route('accounts-transfer') }}"> Go back</a>
                    </span>
                </button>
            </div>
        </div>
    @endif
    @if ($type == 'transfer')
        <div class="containerForm statisticsForm modal-div">
            <h1> Do you really want to transfer: </h1>
            <p><span>{{ $ammount }}</span> EUR</p></br>
            <p>from {{ $iban1 }} account</p></br>
            <p>to {{ $iban2 }} account</p>
            <div class="client-info transfer transfer-modal">
                <form class="reset" action="{{ route('accounts-transferFunds') }}" method="post">
                    <input type="hidden" name="transferFromSelect" value="{{ $iban1 }}">
                    <input type="hidden" name="transferToSelect" value="{{ $iban2 }}">
                    <input type="hidden" name="ammount" value="{{ $ammount }}">
                    <input type="hidden" name="byPass" value="true">
                    <button type="submit" class="button modal-btn modal-btn-yes" id="delete"><span>YES</span></button>
                    @csrf
                </form>
                <button class="button modal-btn modal-btn-no" id="go-back">
                    <span>
                        <a href="{{ route('accounts-transfer') }}"> Go back</a>
                    </span>
                </button>
            </div>
        </div>
    @endif
    @if ($type == 'manual')
        <div class="containerForm statisticsForm modal-div">
            <h1> Do you really want to perform this action? </h1>
            @if ($action == 'plus')
                <p>Add <span>{{ $ammount }}</span> EUR to <span style="color: green;">{{ $iban }}</span>
                    account.</p></br>
            @else
                <p>Take away <span>{{ $ammount }}</span> EUR from <span
                        style="color: green;">{{ $iban }}</span> account.</p></br>
            @endif
            <div class="client-info transfer transfer-modal">
                <form class="reset"
                    action="{{ route('accounts-update', ['client' => $client, 'account' => $account, 'action' => $action, 'page' => $page]) }}"
                    method="post">
                    <input type="hidden" name="ammount" value="{{ $ammount }}">
                    <input type="hidden" name="byPass" value="true">
                    <button type="submit" class="button modal-btn modal-btn-yes" id="delete"><span>YES</span></button>
                    @csrf
                </form>
                <button class="button modal-btn modal-btn-no" id="go-back">
                    <span>
                        <a href="{{ route('clients-show', ['client' => $client, 'page' => $page]) }}"> Go back</a>
                    </span>
                </button>
            </div>
        </div>
    @endif
@endsection
