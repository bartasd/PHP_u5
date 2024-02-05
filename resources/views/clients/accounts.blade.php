@extends('layout')

@section('body')
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID
                </th>
                <th colspan="2">Name
                </th>
                <th colspan="2">Surname
                </th>
                <th colspan="2">ID Code
                </th>
                <th colspan="2">Total Balance
                </th>
                <th colspan="2">Controls
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($clients->count() > 0)
                @for ($i = 10 * ($page > 0 ? $page - 1 : 0); $i < $page * 10; $i++)
                    @if ($i < $clients->count())
                        <tr>
                            <td>{{ $clients[$i]->id }}</td>
                            <td colspan="2">{{ $clients[$i]->name }}</td>
                            <td colspan="2">{{ $clients[$i]->surname }}</td>
                            <td colspan="2">{{ $clients[$i]->id_code }}</td>
                            <td colspan="2">TOTAL BALANCE</td>
                            <td class="multi-button">
                                <button class="button" id="info">
                                    <span>
                                        <a href="{{ route('clients-show', ['client' => $clients[$i], 'page' => $page]) }}">
                                            Info
                                        </a>
                                    </span>
                                </button>
                            </td>
                            <td class="multi-button">
                                <button class="button" id="delete">
                                    <span>Delete</span>
                                </button>
                            </td>
                        </tr>
                    @else
                    @break;
                @endif
            @endfor
        @else
            <tr>
                <td colspan="11">There are no clients yet</td>
            </tr>
        @endif
    </tbody>
    @if ($clients->count() > 10)
        <tfoot>
            <tr>
                @php
                    $totalPages = ceil($clients->count() / 10);
                @endphp
                @if ($totalPages < 12)
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $i]) }}"
                                class="{{ $i == $page ? 'activePage' : '' }}">{{ $i }}</a>
                        </td>
                    @endfor
                @elseif ($totalPages > 11 && $page > 4 && $page < $totalPages - 4)
                    <td><a href="{{ route('clients-accounts.page', ['page' => $page - 1]) }}">
                            <span class="rewind"></span> </a>
                    </td>
                    @for ($i = $page - 4; $i <= $page + 4; $i++)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $i]) }}"
                                class="{{ $i == $page ? 'activePage' : '' }}">{{ $i }}</a></td>
                    @endfor
                    <td><a href="{{ route('clients-accounts.page', ['page' => $page + 1]) }}"> <span
                                class="forward"></span> </a></td>
                @elseif($totalPages > 11 && $page <= 4)
                    @if ($page != 1)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $page - 1]) }}">
                                <span class="rewind"></span> </a>
                        </td>
                    @endif
                    @for ($i = 1; $i <= ($page == 1 ? 10 : 9); $i++)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $i]) }}"
                                class="{{ $i == $page ? 'activePage' : '' }}">{{ $i }}</a>
                        </td>
                    @endfor
                    <td><a href="{{ route('clients-accounts.page', ['page' => $page + 1]) }}"> <span
                                class="forward"></span> </a></td>
                @elseif($totalPages > 11 && $page >= $totalPages - 4)
                    <td><a href="{{ route('clients-accounts.page', ['page' => $page - 1]) }}">
                            <span class="rewind"></span> </a>
                    </td>
                    @for ($i = $totalPages - ($page == $totalPages ? 9 : 8); $i <= $totalPages; $i++)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $i]) }}"
                                class="{{ $i == $page ? 'activePage' : '' }}">{{ $i }}</a>
                        </td>
                    @endfor
                    @if ($page != $totalPages)
                        <td><a href="{{ route('clients-accounts.page', ['page' => $page + 1]) }}"> <span
                                    class="forward"></span> </a></td>
                    @endif
                @endif






            </tr>
        </tfoot>
    @endif
</table>
@endsection
