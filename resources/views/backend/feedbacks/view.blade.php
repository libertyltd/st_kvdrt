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
                    <label class="col-sm-3">Аватар:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->miniatureSrc[0] }}">
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Имя:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Текст отзыва:</label>
                    <div class="col-sm-9">
                        {!! $item->text !!}
                    </div>
                </div>

                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection