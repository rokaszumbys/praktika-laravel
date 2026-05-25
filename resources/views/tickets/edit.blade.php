@extends('adminlte::page')

@section('title', 'Redaguoti bilietą')

@section('content_header')
    <h1>Redaguoti bilietą</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Pavadinimas</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $ticket->title) }}">
                </div>

                <div class="form-group">
                    <label>Aprašymas</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $ticket->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Kategorija</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if($ticket->category_id == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Atnaujinti
                </button>

                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                    Atgal
                </a>
            </form>
        </div>
    </div>

@stop