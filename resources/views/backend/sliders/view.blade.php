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
                    <label class="col-sm-3">Изображение слайда:</label>
                    <div class="col-sm-9">
                        <img src="{{ $item->miniatureSrc[0] }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Текст на слайде:</label>
                    <div class="col-sm-9">
                        {{ $item->promo_text }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Кнопка перехода:</label>
                    <div class="col-sm-9">
                        @if($item->show_button)
                            отображается
                        @else
                            не отображается
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Текст на кнопке перехода:</label>
                    <div class="col-sm-9">
                        {{ $item->button_text }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Ссылка кнопки перехода</label>
                    <div class="col-sm-9">
                        {{ $item->button_link}}
                    </div>
                </div>

                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection