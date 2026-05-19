<x-app-layout>
    <x-slot name="header">
        <h2>Kategorijos</h2>
    </x-slot>

    <div style="padding: 20px;">
        <a href="{{ route('categories.create') }}">Pridėti kategoriją</a>

        <table border="1" cellpadding="10" style="margin-top: 20px;">
            <tr>
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Veiksmai</th>
            </tr>

            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">Redaguoti</a>

                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Trinti</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>