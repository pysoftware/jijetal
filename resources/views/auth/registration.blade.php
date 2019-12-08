@extends('main')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Регистрация</h1>
        <form id="registerForm">
            <div class="form-group">
                <label for="loginInput">Логин</label>
                <input type="text" class="form-control" id="loginInput" placeholder="Login" name="loginInput">
            </div>
            <div class="form-group">
                <label for="passwordInput">Пароль</label>
                <input type="password" class="form-control" id="passwordInput" placeholder="Password"
                       name="passwordInput">
            </div>
            <div class="form-group">
                <label for="repeatPasswordInput">Повторить пароль</label>
                <input type="password" class="form-control" id="repeatPasswordInput" placeholder="Repeat password"
                       name="repeatPasswordInput">
            </div>
            <a href="authorisation">Уже есть аккаут? Зайти сейчас</a> <br>
            <button type="submit" class="btn btn-primary">Регистрация</button>
        </form>
        <h1 id="error"></h1>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#registerForm').submit(function () {
                let $login = $('#loginInput').val();
                let $password1 = $('#passwordInput').val();
                let $password2 = $('#repeatPasswordInput').val();
                $.ajax({
                    url: "{{ route('reg') }}",
                    type: "POST",
                    data: {
                        'login': $login,
                        'password1': $password1,
                        'password2': $password2
                    },
                    cache: false,
                    success: function (url) {
                        window.location.href = url;
                    },
                    error: function (msg) {
                        console.log(JSON.parse(JSON.stringify(msg)));
                        $('#error').text('');
                        let $response = JSON.parse(JSON.stringify(msg));
                        let $errors = Object.entries($response.responseJSON.errors);
                        $errors.forEach(function (item, i, arr) {
                            $('#error').append(arr[i][1] + '<br/>');
                        });
                    }
                });

                return false;
            });
        </script>
    </div>
@endsection
