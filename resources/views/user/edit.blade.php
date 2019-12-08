@extends('main')
@section('content')
    <div class="container-fluid">
        <form id="editForm" method="post">
            <div class="form-group">
                <label for="loginInput">Логин</label>
                <input type="text" class="form-control" id="loginInput" value="{{ $login ?? ''}}"
                       name="loginInput">
            </div>
            <div class="form-group">
                <label for="passwordInput">Пароль</label>
                <input type="text" class="form-control" id="passwordInput" name="passwordInput" placeholder="Пароль">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Сохранить">
        </form>
        <h1 id="error"></h1>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#editForm').submit(function () {
            let $login = $('#loginInput').val();
            let $password = $('#passwordInput').val();
            $.ajax({
                url: '',
                type: "POST",
                data: {
                    'login': $login,
                    'password': $password
                },
                cache: false,
                success: function (url) {
                    window.location.href = url;
                },
                error: function (msg) {
                    console.log(msg);
                    $('#error').text('');
                    let $response = JSON.parse(JSON.stringify(msg));
                    let $errors = Object.entries($response.responseJSON.errors);
                    $errors.forEach(function(item, i, arr) {
                        $('#error').append(arr[i][1] + '<br/>');
                    });
                }
            });

            return false;
        });
    </script>
@endsection
