<x-app-layout>
    <x-slot name="header">
        <h2>Naujas problemos bilietas</h2>
    </x-slot>

    <div style="padding: 20px;">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            <div>
                <label>Pavadinimas</label><br>
                <input type="text" name="title" value="{{ old('title') }}">

                @error('title')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <br>

            <div>
                <label>Aprašymas</label><br>
                <textarea name="description">{{ old('description') }}</textarea>

                @error('description')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <br>

            <div>
                <label>Kategorija</label><br>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <p style="color: red;">{{ $message }}</p>
                @enderror
            </div>

            <br>

            <button type="submit">Išsaugoti</button>
        </form>

        <br>

        <a href="{{ route('tickets.index') }}">Grįžti į sąrašą</a>
    </div>
</x-app-layout>