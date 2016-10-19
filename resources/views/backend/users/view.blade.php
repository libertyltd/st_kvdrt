@extends('layouts.backend')

@section('title')
    {{ $nameAction }}
@endsection

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>{{ $nameAction }}</h1>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <label class="col-sm-3">E-mail</label>
                    <div class="col-sm-9">
                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Роли пользователя</label>
                    <div class="col-sm-9">
                        <ul class="list-group">
                            @foreach($roles as $role)
                                <li class="list-group-item">{{ $role->name_role }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection