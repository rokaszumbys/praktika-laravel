@extends('adminlte::page')

@section('title', 'Bilieto peržiūra')

@section('content_header')
    <h1>Bilieto peržiūra</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $ticket->title }}</h3>
        </div>

        <div class="card-body">
            <p><strong>Aprašymas:</strong> {{ $ticket->description }}</p>
            <p><strong>Kategorija:</strong> {{ $ticket->category->name }}</p>
            <p><strong>Būsena:</strong> {{ $ticket->status }}</p>
            <p><strong>Sukūrė:</strong> {{ $ticket->user->name }}</p>
        </div>
    </div>

    @if(auth()->user()->isSupport() || auth()->user()->isAdmin())
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Keisti būseną</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('tickets.updateStatus', $ticket) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="Naujas" @if($ticket->status == 'Naujas') selected @endif>Naujas</option>
                            <option value="Vykdomas" @if($ticket->status == 'Vykdomas') selected @endif>Vykdomas</option>
                            <option value="Užbaigtas" @if($ticket->status == 'Užbaigtas') selected @endif>Užbaigtas</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Keisti būseną
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pridėti komentarą</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}">
                    @csrf

                    <div class="form-group">
                        <textarea name="comment" class="form-control" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Pridėti komentarą
                    </button>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Komentarai</h3>
        </div>

        <div class="card-body">
            @foreach($ticket->comments as $comment)
                <div class="callout callout-info">
                    <p>{{ $comment->comment }}</p>
                    <small>
                        Parašė: {{ $comment->user->name }} |
                        {{ $comment->created_at }}
                    </small>
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
        Grįžti atgal
    </a>

@stop