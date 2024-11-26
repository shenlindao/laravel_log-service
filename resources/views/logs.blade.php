<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>API Logs</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>IP Address</th>
                    <th>URL</th>
                    <th>Method</th>
                    <th>Input</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->time }}</td>
                        <td>{{ $log->duration }} seconds</td>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->url }}</td>
                        <td>{{ $log->method }}</td>
                        <td>{{ $log->input }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
