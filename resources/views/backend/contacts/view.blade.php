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
                    <label class="col-sm-3">Email</label>
                    <div class="col-sm-9">
                        {{ $email }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Телефон</label>
                    <div class="col-sm-9">
                        {{ $phone }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Ссылка на профиль в Facebook</label>
                    <div class="col-sm-9">
                        <a href="{{ $facebook_link }}">{{ $facebook_link }}</a>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Ссылка на профиль Instagram</label>
                    <div class="col-sm-9">
                        <a href="{{ $instagram_link }}">{{ $instagram_link }}</a>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Адрес</label>
                    <div class="col-sm-9">
                        {{ $address }}
                    </div>
                </div>

                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection