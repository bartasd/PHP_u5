@extends('layout')

@section('body')
    <div class="containerForm">
        <form action="{{ route('clients-store') }}" method="post">
            <p>Please, create Client account</p>
            <input type="text" placeholder="Name" name="name" required><br>
            <input type="text" placeholder="Surname"name="surname" required><br>
            <input type="text" placeholder="ID Code" name="id_code" required><br>
            <input type="submit" value="Create">
            @csrf
        </form>
    </div>
@endsection
