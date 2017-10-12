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
                    <label class="col-sm-3">Название параметра:</label>
                    <div class="col-sm-9">{{ $item->name }}</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <label class="col-sm-3">Минимальное количество</label>
                    <div class="col-sm-9">{{ $item->min_amount }}</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <label class="col-sm-3">Максимальное количество</label>
                    <div class="col-sm-9">{{ $item->max_amount }}</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <label class="col-sm-3">Только один элемент</label>
                    <div class="col-sm-9">{{ isset($item->is_one) ? 'Да' : 'Нет' }}</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-sm-9 col-sm-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">Связанные обязательные параметры</div>
                            <div class="panel-body">
                                @if(isset($item) && $item->children->count() > 0)
                                    <div class="list-group">
                                        @foreach($item->children as $child)
                                            <a href="/home/variable_parapms/{{$child->id}}" target="_blank" class="list-group-item">{{ $child->name }}</a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        Ни одного параметра не привязано
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
                @can('edit', new App\VariableParam())
                <a href="/home/variable_parapms/{{$item->id}}/edit" class="btn btn-primary">Редактировать</a>
                @endcan
            </div>
        </div>
    </div>
@endsection