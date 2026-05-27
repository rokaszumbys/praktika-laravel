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
        <h3 class="card-title">Diagramos</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bilietų būsenų diagrama</h3>
                    </div>

                    <div class="card-body">
                        <div style="max-width: 400px; margin: auto;">
                            <canvas id="ticketsPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bilietų kategorijų diagrama</h3>
                    </div>

                    <div class="card-body">
                        <canvas id="ticketsCategoryBarChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="card">
        <div class="card-header">
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                Sukurti naują bilietą
            </a>
        </div>

        <div class="card-body">
            @if($tickets->count() > 0)
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
            @else
                <div class="alert alert-info">
                    Bilietų nėra.
                </div>
            @endif
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

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const pieCtx = document.getElementById('ticketsPieChart');

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Nauji', 'Vykdomi', 'Užbaigti'],
                datasets: [{
                    data: [
                        {{ $newCount ?? 0 }},
                        {{ $inProgressCount ?? 0 }},
                        {{ $completedCount ?? 0 }}
                    ],
                    backgroundColor: [
                        '#007bff',
                        '#ffc107',
                        '#28a745'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        const barCtx = document.getElementById('ticketsCategoryBarChart');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($categoryLabels ?? []),
                datasets: [{
                    label: 'Bilietų skaičius',
                    data: @json($categoryCounts ?? []),
                    backgroundColor: [
                        '#007bff',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#17a2b8',
                        '#6f42c1',
                        '#fd7e14',
                        '#20c997'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@stop