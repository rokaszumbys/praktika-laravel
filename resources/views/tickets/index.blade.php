<x-app-layout>
    <x-slot name="header">
        <h2>Problemų sąrašas</h2>
    </x-slot>

    <div style="padding: 20px;">
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <a href="{{ route('tickets.create') }}">Sukurti naują bilietą</a>

        <table border="1" cellpadding="10" style="margin-top: 20px; width: 100%;">
            <tr>
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Kategorija</th>
                <th>Būsena</th>
                <th>Savininkas</th>
                <th>Veiksmai</th>
            </tr>

            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}">Peržiūrėti</a>

                        @if(auth()->id() === $ticket->user_id || auth()->user()->isAdmin())
                            | <a href="{{ route('tickets.edit', $ticket) }}">Redaguoti</a>

                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Trinti</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>

@if(auth()->user()->isAdmin() || auth()->user()->isSupport())
    <hr>

    <h3>Aktyvių problemų ataskaita</h3>

    <a href="{{ route('reports.activeTicketsPdf') }}">Atsisiųsti PDF</a>

    <form method="POST" action="{{ route('reports.activeTicketsSend') }}" style="margin-top: 10px;">
        @csrf

        <input type="email" name="email" placeholder="Įveskite el. paštą">

        <button type="submit">Siųsti PDF el. paštu</button>
    </form>
@endif