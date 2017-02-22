@extends('layouts.backend')

@section('title', 'Описание раздела "Выполненные работы"')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Описание раздела "Выполненные работы" <span class="label label-warning">Может быть только один элемент с описанием</span></h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\WorkDescription())
                            <a class="btn btn-default" href="{{ url('/home/work_description/create') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новые данные">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        @if ($item)
                            <table class="table table-striped table-hover">
                                <div class="row">
                                    <div class="col-sm-2">#</div>
                                    <div class="col-sm-6">Текст</div>
                                    <div class="col-sm-4"></div>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-2">{{ $item->id }}</div>
                                        <div class="col-sm-6">{{ $item->description }}</div>
                                        <div class="col-sm-4">
                                            @can('edit', new App\WorkDescription())
                                                <a class="btn btn-info" href="{{ url('/home/work_description/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\WorkDescription())
                                                @can('view', new App\WorkDescription())
                                                    <a class="btn btn-info" href="{{ url('/home/work_description/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                                @endcan
                                            @endcannot
                                            @can('delete', new App\WorkDescription())
                                                <form action="{{ url('/home/work_description/'.$item->id.'/') }}" method="POST" class="form_action">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-danger" type="submit" data-toggle="countdown"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                </form>
                                            @endcan
                                        </div>

                                    </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <strong>Ни одного элемента не добавлено.</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection