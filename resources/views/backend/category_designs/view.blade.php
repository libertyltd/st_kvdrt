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
                    <label class="col-sm-3">Название:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->name }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Цена:</label>
                    <div class="col-sm-9">
                        {{ $item->price }}
                    </div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection