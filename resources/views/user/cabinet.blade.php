@extends('main')

@section('content')
    <script>
        $(document).ready(function () {
            $(".delete").click(function () {
                let $id = $(this).attr('id');
                var alert = confirm("Вы уверены, что хотите удалить пользователя?");
                if (alert) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: $(this).attr('href'),
                        type: "POST",
                        data: {
                            'id': $id
                        },
                        cache: false,
                        success: function (url) {
                            window.location.href = url;
                        }
                    });
                } else {
                    console.log('jfajf');
                }
                return false;
            });
        });
    </script>
    <div class="container-fluid">
        <h1>Hello, {{ session('login') }}</h1>
        <a href="logout">
            <p class="text-center">Logout</p>
        </a>
        <a href="edit">
            <p class="text-center">Edit</p>
        </a>
        @if(isset($users))
            <div id="alert"></div>
            <h3>Сортировка</h3>
            <a href="{{ route('cabinet', ['sort'=>'asc']) }}">По возрастанию</a>
            <a href="{{ route('cabinet', ['sort'=>'desc']) }}">По убыванию</a>
            {{ $users->links() }}
            <form action="{{route('cabinet')}}" method="get">
                <div class="form-group">
                    <label for="findInput">Паттерн</label>
                    <input type="text" class="form-control" id="findInput" name="findInput">
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Найти">
            </form>
            @foreach ($users as $user)
                <div class="user">{{ $user->login }}</div>
                <a href="edit/{{ $user->id }}">Редактировать</a>
                <a href="delete/{{ $user->id }}" id="{{$user->id}}" class="delete">Удалить</a>
            @endforeach
        @endif
    </div>

@endsection
