@extends('main')

@section('content')
    <h1 class="text-center">Авторизация</h1>
    <div class="container-fluid">
        <form id="authForm">
            <div class="form-group">
                <label for="loginInput">Логин</label>
                <input type="text" class="form-control" id="loginInput" placeholder="Login" name="loginInput">
            </div>
            <div class="form-group">
                <label for="passwordInput">Пароль</label>
                <input type="password" class="form-control" id="passwordInput" placeholder="Password" name="passwordInput">
            </div>
            <a href="registration">Зарегаться</a> <br>
            <input type="submit" class="btn btn-primary" name="submit" value="Login">
        </form>
        <h1 id="error"></h1>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#authForm').submit(function () {
            let $email = $('#loginInput').val();
            let $password = $('#passwordInput').val();
            $.ajax({
                url: '{{ route('auth') }}',
                type: "POST",
                data: {
                    'login': $email,
                    'password': $password
                },
                cache: false,
                success: function(url) {
                    window.location.href = url;
                },
                error: function(msg) {
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

