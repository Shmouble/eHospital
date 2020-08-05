@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Добро пожаловать!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class = "btn btn-block btn-default">Вы успешно вошли в систему </div>
                        <br>
                        <a class="btn btn-block btn-default" href="{{ url('/admin') }}">Перейти на страницу управления</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
