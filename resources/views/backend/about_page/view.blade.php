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
                    <label class="col-sm-3">Описание:</label>
                    <div class="col-sm-9">
                        {!! $item->description !!}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Статус записи:</label>
                    <div class="col-sm-9">
                        @if($item->status)
                            Запись активна
                        @else
                            Запись не активна
                        @endif
                    </div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection