@extends('layout')

@section('body')
    <div class="containerForm statisticsForm">
        <div class="client-info transfer add-box">
            <form class="reset add-form" action="{{ route('clients-store') }}" method="post">
                <h1>Please, create a Client</h1>
                <input type="text" placeholder="Name" name="name" required><br>
                <input type="text" placeholder="Surname"name="surname" required><br>
                <input type="text" placeholder="ID Code" name="id_code" required><br>
                <button type="submit" class="button" id="transfer">
                    <span>Create</span>
                </button>
                @csrf
            </form>
        </div>
    </div>
@endsection
