@extends('layout')

@section('body')
    <div class="containerForm statisticsForm">
        <h1>Statistics</h1>
        <table class="table table-success table-striped stats">
            <tbody>
                <tr>
                    <td>Number of Clients: </td>
                    <td>{{ $clients->count() }}</td>
                </tr>
                <tr>
                    <td>Number of Clients Accounts: </td>
                    <td>{{ $accounts->count() }}</td>
                </tr>
                <tr>
                    <td>Number of Clients empty Accounts: </td>
                    <td>{{ $accounts->filter(function ($item, $key) {return $item['balance'] == 0;})->count() }}
                    </td>
                </tr>
                <tr>
                    <td>Number of Clients negative Accounts: </td>
                    <td>{{ $accounts->filter(function ($item, $key) {return $item['balance'] < 0;})->count() }}
                    </td>
                </tr>
                <tr>
                    <td>Total sum of all holdings: </td>
                    <td>{{ number_format($accounts->pluck('balance')->sum(), 2, '.', '') }} EUR</td>
                </tr>
                @php
                    $maxBalance = $accounts->max('balance');
                    $maxClientId = $accounts->where('balance', $maxBalance)->first()->owner_id;
                    $clientWithMaxBalance = $clients->firstWhere('id', $maxClientId);
                @endphp
                <tr>
                    <td>Biggest sum holding in one Account</td>
                    <td>{{ number_format($maxBalance, 2, '.', '') }} EUR</td>
                </tr>
                <tr>
                    <td>Biggest Accounts holder info: </td>
                    <td class="multi-button">
                        <button class="button" id="info">
                            <span>
                                <a href="{{ route('clients-show', ['client' => $clientWithMaxBalance, 'page' => 0]) }}">
                                    Info
                                </a>
                            </span>
                        </button>
                    </td>
                </tr>
                @php
                    $sumsByOwner = $accounts->groupBy('owner_id')->map(function ($accounts) {
                        return $accounts->sum('balance');
                    });
                    $averagePortfolio = $sumsByOwner->avg();
                    $maxPortfolio = $sumsByOwner->max();
                    $clientWithMaxPortfolioID = $sumsByOwner
                        ->sortByDesc(function ($sum) {
                            return $sum;
                        })
                        ->keys()
                        ->first();
                    $accsAbove = $sumsByOwner
                        ->filter(function ($item) use ($averagePortfolio) {
                            return $item >= $averagePortfolio;
                        })
                        ->count();
                @endphp
                <tr>
                    <td>Biggest sum of one holders all Accounts</td>
                    <td>{{ number_format($maxPortfolio, 2, '.', '') }} EUR</td>
                </tr>
                <tr>
                    <td>Biggest holder info: </td>
                    <td class="multi-button">
                        <button class="button" id="info">
                            <span>
                                <a href="{{ route('clients-show', ['client' => $clientWithMaxPortfolioID, 'page' => 0]) }}">
                                    Info
                                </a>
                            </span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Average holding: </td>
                    <td>{{ number_format($averagePortfolio, 2, '.', '') }} EUR</td>
                </tr>
                <tr>
                    <td>Clients count that are above or equal to average holding: </td>
                    <td>{{ $accsAbove }}</td>
                </tr>
                <tr>
                    <td>Clients count that are below average holding: </td>
                    <td>{{ $clients->count() - $accsAbove }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
