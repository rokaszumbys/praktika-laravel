<x-app-layout>
    <x-slot name="header">
        <h2>Bilieto peržiūra</h2>
    </x-slot>

    <div style="padding: 20px;">
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <p><strong>Pavadinimas:</strong> {{ $ticket->title }}</p>
        <p><strong>Aprašymas:</strong> {{ $ticket->description }}</p>
        <p><strong>Kategorija:</strong> {{ $ticket->category->name }}</p>
        <p><strong>Būsena:</strong> {{ $ticket->status }}</p>
        <p><strong>Sukūrė:</strong> {{ $ticket->user->name }}</p>

        @if(auth()->user()->isSupport() || auth()->user()->isAdmin())
            <hr>

            <h3>Keisti būseną</h3>

            <form method="POST" action="{{ route('tickets.updateStatus', $ticket) }}">
                @csrf
                @method('PATCH')

                <select name="status">
                    <option value="Naujas" @if($ticket->status == 'Naujas') selected @endif>Naujas</option>
                    <option value="Vykdomas" @if($ticket->status == 'Vykdomas') selected @endif>Vykdomas</option>
                    <option value="Užbaigtas" @if($ticket->status == 'Užbaigtas') selected @endif>Užbaigtas</option>
                </select>

                <button type="submit">Keisti būseną</button>
            </form>

            <hr>

            <h3>Pridėti komentarą</h3>

            <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}">
                @csrf

                <textarea name="comment"></textarea><br>

                <button type="submit">Pridėti komentarą</button>
            </form>
        @endif

        <hr>

        <h3>Komentarai</h3>

        @foreach($ticket->comments as $comment)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <p>{{ $comment->comment }}</p>
                <small>Parašė: {{ $comment->user->name }} | {{ $comment->created_at }}</small>
            </div>
        @endforeach

        <br>

        <a href="{{ route('tickets.index') }}">Grįžti atgal</a>
    </div>
</x-app-layout>