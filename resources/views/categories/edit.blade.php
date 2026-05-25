@extends('adminlte::page')

@section('title', 'Redaguoti kategoriją')

@section('content_header')
    <h1>Redaguoti kategoriją</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Pavadinimas</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    Atnaujinti
                </button>

                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Atgal
                </a>
            </form>
        </div>
    </div>

@stop