@extends('adminlte::page')

@section('title', 'Nauja kategorija')

@section('content_header')
    <h1>Nauja kategorija</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="form-group">
                    <label>Pavadinimas</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    Išsaugoti
                </button>

                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Atgal
                </a>
            </form>
        </div>
    </div>

@stop