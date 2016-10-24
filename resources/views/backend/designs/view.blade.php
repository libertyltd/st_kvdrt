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
                    <label class="col-sm-3">Название дизайна:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Краткое описание (отображается на внешнем сайте):</label>
                    <div class="col-sm-9">
                        {{ $item->lead_description }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Подробное описание (экспериментальное поле, не отображается на внешней части сайта):</label>
                    <div class="col-sm-9">
                        {!! $item->description !!}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Цена дизайна от:</label>
                    <div class="col-sm-9">
                        {{ $item->price }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-9">
                        @if($item->show_in_main)
                            Отображается на главной странице
                        @else
                            Не отображается на главной
                        @endif
                    </div>
                </div>

                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection