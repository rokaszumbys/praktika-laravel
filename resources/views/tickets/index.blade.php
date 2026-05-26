@extends('adminlte::page')

@section('title', $pageTitle ?? 'Bilietai')

@section('content_header')
    <h1>{{ $pageTitle ?? 'Bilietai' }}</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                Sukurti naują bilietą
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pavadinimas</th>
                        <th>Kategorija</th>
                        <th>Būsena</th>
                        <th>Savininkas</th>
                        <th>Veiksmai</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>
                                @if($ticket->status == 'Naujas')
                                    <span class="badge badge-primary">Naujas</span>
                                @elseif($ticket->status == 'Vykdomas')
                                    <span class="badge badge-warning">Vykdomas</span>
                                @elseif($ticket->status == 'Užbaigtas')
                                    <span class="badge badge-success">Užbaigtas</span>
                                @else
                                    <span class="badge badge-secondary">{{ $ticket->status }}</span>
                                @endif
                            </td>
                            <td>{{ $ticket->user->name }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                                    Peržiūrėti
                                </a>

                                @if(auth()->id() === $ticket->user_id || auth()->user()->isAdmin())
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning btn-sm">
                                        Redaguoti
                                    </a>

                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Trinti
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isSupport())
            <div class="card-footer">
                <a href="{{ route('reports.activeTicketsPdf') }}" class="btn btn-secondary">
                    Atsisiųsti aktyvių problemų PDF
                </a>

                <form method="POST" action="{{ route('reports.activeTicketsSend') }}" style="display:inline-block; margin-left: 10px;">
                    @csrf

                    <input type="email" name="email" placeholder="El. paštas" required>

                    <button type="submit" class="btn btn-success">
                        Siųsti PDF el. paštu
                    </button>
                </form>
            </div>
        @endif
    </div>

@stop