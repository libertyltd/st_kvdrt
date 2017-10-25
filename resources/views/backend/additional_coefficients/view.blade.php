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
                <div class="row" style="margin-bottom: 10px;">
                    <label class="col-sm-3">Процент от стоимости:</label>
                    <div class="col-sm-9">{{ $item->percent }}</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <label class="col-sm-3">Комментарий:</label>
                    <div class="col-sm-9">{{ $item->name }}</div>
                </div>
                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
                @can('edit', new App\AdditionalCoefficient())
                <a href="/home/additional_coefficients/{{$item->id}}/edit" class="btn btn-primary">Редактировать</a>
                @endcan
            </div>
        </div>
    </div>
@endsection