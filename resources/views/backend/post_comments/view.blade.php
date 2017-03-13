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
                    <label class="col-sm-3">Автор:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Email автора:</label>
                    <div class="col-sm-9">
                        {{ $item->email }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Дата создания комментария:</label>
                    <div class="col-sm-9">
                        {{ date('d-m-Y', strtotime($item->date_create)) }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Текст сообщения:</label>
                    <div class="col-sm-9">
                        {{ $item->message }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3">Пост:</label>
                    <div class="col-sm-9">
                        @if($item->post_id)
                            <a href="{{ url('/home/posts/'.$item->post_id) }}">{{ date('d-m-Y', strtotime($item->post->date_publication)) }} - {{ $item->post->name }}</a>
                        @endif
                    </div>
                </div>
                <div class="btn-group">
                    <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
                    <a href="{{ url('/home/post_comments/'.$item->id.'/edit') }}" class="btn btn-info">Редактировать</a>
                </div>
            </div>
        </div>
    </div>
@endsection