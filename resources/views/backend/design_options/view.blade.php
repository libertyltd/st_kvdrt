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
                    <label class="col-sm-3">Цвет:</label>
                    <div class="col-sm-9">
                        <div style="display: block; width: 50px; height: 50px; background: #{{$item->color}}"></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Гостинная:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->hall[0] }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Ванная:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->bath[0] }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Название опции:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Дизайн</label>
                    <div class="col-sm-9">
                        {{ $item->CategoryDesign->Design->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Категория</label>
                    <div class="col-sm-9">
                        {{ $item->CategoryDesign->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Цена</label>
                    <div class="col-sm-9">
                        {{ \App\Design::formatPrice($item->price) }}
                    </div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection