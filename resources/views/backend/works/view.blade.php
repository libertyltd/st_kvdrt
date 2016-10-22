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
                    <label class="col-sm-3">Главное изображение работы:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->miniatureSrc[0] }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Название с метражем:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Метраж:</label>
                    <div class="col-sm-9">
                        {{ $item->square }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Описание:</label>
                    <div class="col-sm-9">
                        {{ $item->description }}
                    </div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection