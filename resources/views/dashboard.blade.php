@extends('adminlte::page')

@section('title', 'Pagrindinis puslapis')

@section('content_header')
    <h1>Pagrindinis puslapis</h1>
@stop

@section('content')

    {{-- Statistikos kortelės --}}
    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $allTicketsCount ?? 0 }}</h3>
                    <p>Visi bilietai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('tickets.index') }}" class="small-box-footer">
                    Peržiūrėti <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $newCount ?? 0 }}</h3>
                    <p>Nauji bilietai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <a href="{{ route('tickets.new') }}" class="small-box-footer">
                    Peržiūrėti <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $inProgressCount ?? 0 }}</h3>
                    <p>Vykdomi bilietai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <a href="{{ route('tickets.inProgress') }}" class="small-box-footer">
                    Peržiūrėti <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $completedCount ?? 0 }}</h3>
                    <p>Užbaigti bilietai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('tickets.completed') }}" class="small-box-footer">
                    Peržiūrėti <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- Diagramos --}}
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
                            <h3 class="card-title">Bilietai pagal būseną</h3>
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
                            <h3 class="card-title">Bilietai pagal kategorijas</h3>
                        </div>

                        <div class="card-body">
                            <canvas id="ticketsCategoryBarChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Greitos nuorodos --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Greitos nuorodos</h3>
        </div>

        <div class="card-body">

            <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                Visi bilietai
            </a>

            <a href="{{ route('tickets.create') }}" class="btn btn-success">
                Sukurti naują bilietą
            </a>

            <a href="{{ route('tickets.new') }}" class="btn btn-info">
                Nauji bilietai
            </a>

            <a href="{{ route('tickets.inProgress') }}" class="btn btn-warning">
                Vykdomi bilietai
            </a>

            <a href="{{ route('tickets.completed') }}" class="btn btn-secondary">
                Užbaigti bilietai
            </a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('categories.index') }}" class="btn btn-dark">
                    Kategorijos
                </a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isSupport())
                <a href="{{ route('reports.activeTicketsPdf') }}" class="btn btn-danger">
                    PDF ataskaita
                </a>
            @endif

        </div>
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