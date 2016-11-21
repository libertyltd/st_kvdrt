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
                    <label class="col-sm-3">Оригинальный URL:</label>
                    <div class="col-sm-9">
                        {{ $item->original_url }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Алиас URL:</label>
                    <div class="col-sm-9">
                        {{ $item->alias_url }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Заголовок:</label>
                    <div class="col-sm-9">
                        {{ $item->title }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Ключевые слова:</label>
                    <div class="col-sm-9">
                        {{ $item->keywords }}
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