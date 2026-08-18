<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="/KZ_Module_B/bootstrap/css/bootstrap.min.css" />
</head>
<body>
    <div class="container-sm">
        <div class="d-flex flex-column justify-content-center align-items-center vh-100">
            <h1>
                Stations
            </h1>

            <hr />

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            Code
                        </th>
                        <th>
                            Station
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stations as $station)
                        <tr>
                            <td>
                                {{$station->code}}
                            </td>
                            <td>
                                <a href="/KZ_Module_B/board/{{$station->code}}">
                                    {{$station->name}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="/KZ_Module_B/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
