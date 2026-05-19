<x-app-layout>
    <x-slot name="header">
        <h2>Redaguoti kategoriją</h2>
    </x-slot>

    <div style="padding: 20px;">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf
            @method('PUT')

            <label>Pavadinimas</label><br>
            <input type="text" name="name" value="{{ $category->name }}">

            <br><br>

            <button type="submit">Atnaujinti</button>
        </form>
    </div>
</x-app-layout>