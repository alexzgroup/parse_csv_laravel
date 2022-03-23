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
                            <form class="d-flex" id="form_data" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-file col">
                                    <input type="file" class="form-file-input" name="csv" id="customFile">
                                    <label class="form-file-label" for="customFile">
                                        <span class="form-file-text">Choose file...</span>
                                        <span class="form-file-button">Browse</span>
                                    </label>
                                </div>
                                <button class="col btn btn-outline-success" type="submit">
                                    Parse File
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                                <button class="col btn btn-outline-danger mx-2" onclick="send_form();" type="button">
                                    Ajax Request
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div id="content_wrapper">
            @include('results')
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        function send_form(){
            let formData = new FormData(document.forms.form_data);
                formData.append('ajax', '1');

            $.ajax({
                url: '/api/parse-file',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "html",
                beforeSend: function () {
                    $('form button').prop('disabled', true);
                },
                complete: function() {
                    $('form button').prop('disabled', false);
                },
                success: function (html) {
                    $('#content_wrapper').html(html);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
            });
        }
    </script>
    <style type="text/css">
        form button:not([disabled]) span{
            display: none;
        }
    </style>
</html>
