<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aktyvių problemų ataskaita</title>
</head>
<body>
    <h1>Aktyvių problemų ataskaita</h1>

    <table border="1" cellpadding="8" width="100%">
        <tr>
            <th>ID</th>
            <th>Pavadinimas</th>
            <th>Kategorija</th>
            <th>Būsena</th>
            <th>Vartotojas</th>
            <th>Sukurta</th>
        </tr>

        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->category->name }}</td>
                <td>{{ $ticket->status }}</td>
                <td>{{ $ticket->user->name }}</td>
                <td>{{ $ticket->created_at }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>