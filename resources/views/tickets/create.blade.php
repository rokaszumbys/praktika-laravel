@extends('adminlte::page')

@section('title', 'Naujas bilietas')

@section('content_header')
    <h1>Naujas problemos bilietas</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="form-group">
                    <label>Pavadinimas</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">

                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Aprašymas</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kategorija</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Išsaugoti
                </button>

                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    Atgal
                </a>
            </form>
        </div>
    </div>

@stop