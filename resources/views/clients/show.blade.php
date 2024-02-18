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
                        <a href={{ route('clients-edit', ['client' => $client, 'page' => $page]) }}>Edit</a>
                    </span>
                </button>
                <button class="button" id="go-back">
                    <span>
                        @if ($page == 0)
                            <a href="{{ route('home') }}"> Go back</a>
                        @else
                            <a href="{{ route('clients-accounts.page', $page) }}"> Go back</a>
                        @endif
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
                    @forelse($accs as $acc)
                        <tr>
                            @php
                                $iban = $acc->iban;
                                $formatted_iban = substr($iban, 0, 4) . ' ' . substr($iban, 4, 4) . ' ' . substr($iban, 8, 4) . ' ' . substr($iban, 12, 4) . ' ' . substr($iban, 16);
                                $formatted_bal = number_format((float) $acc->balance, 2, '.', '');
                            @endphp
                            <td>{{ $formatted_iban }}</td>
                            <td> {{ $formatted_bal }} EUR</td>
                            <td>
                                <button class="ctrl-button ctrl-button-plus">
                                    <span>
                                        <a
                                            href="{{ route('accounts-edit', ['client' => $client, 'account' => $acc, 'action' => 'plus', 'page' => $page]) }} ">+</a>
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button class="ctrl-button ctrl-button-minus">
                                    <span>
                                        <a
                                            href="{{ route('accounts-edit', ['client' => $client, 'account' => $acc, 'action' => 'minus', 'page' => $page]) }} ">-</a>
                                    </span>
                                </button>
                            </td>
                            <td class="multi-button">
                                <form class="ctrl-button ctrl-button-delete meh"
                                    action="{{ route('accounts-destroy', ['account' => $acc, 'client' => $client, 'page' => $page]) }}"
                                    method="post">
                                    <button type="submit"><span>x</span></button>
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Client doesn't have available accounts just yet.</td>
                        </tr>
                    @endforelse


                    <tr>
                        <td>Create new account: </td>
                        <td colspan="4">
                            <form class="reset deductForm"
                                action="{{ route('accounts-store', ['client' => $client, 'page' => $page]) }}"
                                method="post">
                                <div>
                                    <button type="submit" class="ctrl-button ctrl-button-create">
                                        <span>
                                            <a>Create</a>
                                        </span>
                                    </button>
                                </div>
                                @csrf
                            </form>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        @if (count($accs) != 0)
                            <td>Total balance: </td>
                            @php
                                $formattedBalance = number_format((float) $accs->sum('balance'), 2, '.', '');
                            @endphp
                            <td> {{ $formattedBalance }} EUR</td>
                        @else
                            <td>Total balance: </td>
                            <td></td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
