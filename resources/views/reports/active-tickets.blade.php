<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }
    </style>

    <title>Aktyvių problemų ataskaita</title>
</head>
<body>

    <h1>Aktyvių problemų ataskaita</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Kategorija</th>
                <th>Būsena</th>
                <th>Vartotojas</th>
                <th>Sukurta</th>
            </tr>
        </thead>

        <tbody>
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
        </tbody>
    </table>

</body>
</html>