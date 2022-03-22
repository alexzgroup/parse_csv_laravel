<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Parse CSV</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-5">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <form class="d-flex" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-file col">
                                    <input type="file" class="form-file-input" name="csv" id="customFile">
                                    <label class="form-file-label" for="customFile">
                                        <span class="form-file-text">Choose file...</span>
                                        <span class="form-file-button">Browse</span>
                                    </label>
                                </div>
                                <button class="col btn btn-outline-success" type="submit">Parse File</button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col">
                @if (!empty($file_info))
                    <table class="table table-dark table-bordered">
                        <thead>
                            <tr>
                                @foreach (array_keys($file_info) as $key)
                                    <th>{{ $key }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($file_info as $property)
                                    <td>{{ $property }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @elseif (Request::isMethod('post'))
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @endif
            </div>
        </div>

        @if (!empty($data['items']))
            <div class="row">
                <div class="col" id="results">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @foreach ($data['keys'] as $key)
                                <th scope="col">{{ $key }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['items'] as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->year }}</td>
                                <td>{{ $item->industry_code }}</td>
                                <td>{{ $item->industry_name }}</td>
                                <td>{{ $item->rme_size_grp }}</td>
                                <td>{{ $item->variable }}</td>
                                <td>{{ $item->value }}</td>
                                <td>{{ $item->unit }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="8" class="ajax_pager">
                                <div class="">
                                    {{ $data['items']->links() }}
                                </div>
                                <div class="">
                                   Total: {{ $data['items']->total() }}
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endif
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>
