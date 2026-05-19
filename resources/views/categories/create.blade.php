<x-app-layout>
    <x-slot name="header">
        <h2>Nauja kategorija</h2>
    </x-slot>

    <div style="padding: 20px;">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <label>Pavadinimas</label><br>
            <input type="text" name="name">

            <br><br>

            <button type="submit">Išsaugoti</button>
        </form>
    </div>
</x-app-layout>