@extends('layouts.backend')

@section('title', 'Обязательные параметры заказа')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Обязательные параметры заказа</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\VariableParam())
                            <a class="btn btn-default" href="{{ url('/home/variable_parapms/create') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новый параметр">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        @if ($list->count() != 0)
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-sm-2"><strong>#</strong></div>
                                <div class="col-sm-6"><strong>Навзание</strong></div>
                                <div class="col-sm-4"></div>
                            </div>
                                @foreach($list as $item)
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-sm-2">
                                        @if($item->status == 0)
                                            <span class="label label-danger">{{ $item->id }}</span>
                                        @else
                                            <span class="label label-success">{{ $item->id }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">{{ $item->name }}</div>
                                        <div class="col-sm-4">
                                            @can('edit', new App\VariableParam())
                                                <a class="btn btn-info" href="{{ url('/home/variable_parapms/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\VariableParam())
                                                @can('view', new App\VariableParam())
                                                    <a class="btn btn-info" href="{{ url('/home/variable_parapms/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                                @endcan
                                            @endcannot
                                            @can('delete', new App\VariableParam())
                                                <form action="{{ url('/home/variable_parapms/'.$item->id.'/') }}" method="POST" class="form_action">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-danger" type="submit" data-toggle="countdown"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                </form>
                                            @endcan
                                    </div>
                                </div>
                                @endforeach
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