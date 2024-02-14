@extends('layout')

@section('body')
    <div class="acc-cont">
        <div class="filter-sorting">
            <div>
                <form id="sorting_select" class="reset" action="{{ route('clients-sort', ['page' => $page]) }}" method="post">
                    <select name="sort" id="sorts">
                        <option value="surname_a" selected disabled hidden>Sort by:</option>
                        <option value="id_a">ID asc</option>
                        <option value="id_d">ID des</option>
                        <option value="name_a">Name asc</option>
                        <option value="name_d">Name des</option>
                        <option value="surname_a">Surname asc</option>
                        <option value="surname_d">Surname des</option>
                        <option value="id_code_a">ID code asc</option>
                        <option value="id_code_d">ID code des</option>
                        <option value="balance_a">Balance asc</option>
                        <option value="balance_d">Balance des</option>
                    </select>
                    @csrf
                </form>
                <script>
                    const sortForm = document.getElementById("sorting_select");
                    const sortSelect = document.getElementById("sorts");
                    sortSelect.addEventListener("change", function() {
                        sortForm.submit();
                    });
                </script>
            </div>
            <div>
                <form id="filtering_select" class="reset" action="{{ route('clients-filter', ['page' => $page]) }}"
                    method="post">
                    <select name="filter" id="filters">
                        <option value="all" selected disabled hidden>Filter by:</option>
                        <option value="all">All clients</option>
                        <option value="no_acc">Clients with no accounts</option>
                        <option value="empty_acc">Clients with empty accounts</option>
                        <option value="non_empty_acc">Clients with non-empty accounts</option>
                        <option value="negative_acc">Clients with negative accounts</option>
                    </select>
                    @csrf
                </form>
                <script>
                    const filterForm = document.getElementById("filtering_select");
                    const filterSelect = document.getElementById("filters");
                    filterSelect.addEventListener("change", function() {
                        filterForm.submit();
                    });
                </script>
            </div>
        </div>

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
                                @php
                                    $totalBalance = $accs->where('owner_id', $clients[$i]->id)->sum('balance');
                                @endphp
                                @if ($totalBalance)
                                    @php
                                        $formattedBalance = number_format((float) $totalBalance, 2, '.', '');
                                    @endphp
                                    <td colspan="2">{{ $formattedBalance }} EUR</td>
                                @else
                                    <td colspan="2">0.00 EUR</td>
                                @endif

                                <td class="multi-button">
                                    <button class="button" id="info">
                                        <span>
                                            <a
                                                href="{{ route('clients-show', ['client' => $clients[$i], 'page' => $page]) }}">
                                                Info
                                            </a>
                                        </span>
                                    </button>
                                </td>
                                <td class="multi-button">
                                    <form action="{{ route('clients-destroy', $clients[$i]) }}" method="post">
                                        <button type="submit" class="button" id="delete"><span>Delete</span></button>
                                        @csrf
                                        @method('delete')
                                    </form>
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
</div>
@endsection
