<!DOCTYPE html>
<html>
<head>
    <title>Visitor List</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* IMPORTANT for PDF */
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            word-wrap: break-word;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
        }
        thead {
            display: table-header-group;
        }
        tbody {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid;
        }

        th:nth-child(1), td:nth-child(1) { width: 12%; }
        th:nth-child(2), td:nth-child(2) { width: 20%; }
        th:nth-child(3), td:nth-child(3) { width: 20%; }
        th:nth-child(4), td:nth-child(4) { width: 25%; }
        th:nth-child(5), td:nth-child(5) { width: 23%; }
    </style>
</head>

<body>

<h3>Visitor List</h3>

<table>
    <thead>
        <tr>
            <th>Visitor ID</th>
            <th>Name</th>
            <th>Tenant</th>
            <th>Purpose</th>
            <th>Date Entered</th>
        </tr>
    </thead>

    <tbody>
        @foreach($visitors as $visitor)
        <tr>
            <td>{{ $visitor->visitor_id }}</td>
            <td>{{ $visitor->name }}</td>
            <td>{{ $visitor->tenant_name }}</td>
            <td>{{ $visitor->purpose }}</td>
            <td>{{ optional($visitor->created_at)->format('m/d/Y h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>