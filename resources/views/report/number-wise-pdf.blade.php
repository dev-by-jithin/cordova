<h3 align="center">Number Wise Report</h3>
<table align="center" border="1" width="50%" cellpadding="5" cellspacing="0" style="margin-bottom:10px;">
    <thead>
        <tr>
            <th>Date</th>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <th>Ticket</th>
            <td>{{ $ticket }}</td>
        </tr>
        <tr>
            <th>Total Count</th>
            <td>{{ $count }}</td>
        </tr>
        <tr>
            <th>Created Time</th>
            <td>{{ $created_at }}</td>
        </tr>
    </thead>
</table>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Serial No</th>
            @if($column == 'yes')
            <th>Ticket</th>
            @endif
            <th>Ticket Number</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            @if($column == 'yes')
            <td>{{ $row->ticket_name }} {{ $row->mode_name }}</td>
            @endif
            <td>{{ $row->number }}</td>
            <td>{{ $row->count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
