<h1>{{ $name  }}</h1>
<br />
<hr>
<br />
<table>
    <thead>
        @foreach ($columns as $column)
            <th>{{ $column->name }}</th>
        @endforeach
    </thead>
    <thead>
        @foreach ($values as $row)
            <tr>
                @foreach ($row as $key => $col)
                    <td>{{ $col->value }}</td>
                @endforeach
            </tr>
        @endforeach
    </thead>
</table>