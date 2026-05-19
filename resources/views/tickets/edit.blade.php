<x-app-layout>
    <x-slot name="header">
        <h2>Redaguoti bilietą</h2>
    </x-slot>

    <div style="padding: 20px;">
        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Pavadinimas</label><br>
                <input type="text" name="title" value="{{ old('title', $ticket->title) }}">
            </div>

            <br>

            <div>
                <label>Aprašymas</label><br>
                <textarea name="description">{{ old('description', $ticket->description) }}</textarea>
            </div>

            <br>

            <div>
                <label>Kategorija</label><br>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if($ticket->category_id == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <button type="submit">Atnaujinti</button>
        </form>
    </div>
</x-app-layout>