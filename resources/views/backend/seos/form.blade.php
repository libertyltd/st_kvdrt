@extends('layouts.backend')

@section('title')
    {{ $nameAction }}
@endsection

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>{{ $nameAction }}</h1>
        @include('backend.common.form.contextmessages')
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                      @if ($controllerAction === 'add')
                      action="{{ url("{$controllerPathList}") }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url("{$controllerPathList}".$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="original_url" class="col-sm-3 control-label">Оригинальный URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="original_url" id="original_url" class="form-control" maxlength="255" value="{{ isset($item->original_url) ? $item->original_url : '' }}" required>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Обязательное для заполнения поле. URL адрес должен быть относительным. Пример: /example/page</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alias_url" class="col-sm-3 control-label">Псевдоним URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="alias_url" id="alias_url" class="form-control" maxlength="255" value="{{ isset($item->alias_url) ? $item->alias_url : '' }}">
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-warning">URL адрес должен быть относительным. Пример: /example/page</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <textarea name="title" id="title" rows="5" maxlength="255" class="form-control">{{ isset($item->title) ? $item->title : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keywords" class="col-sm-3 control-label">Ключевые слова</label>
                        <div class="col-sm-9">
                            <textarea name="keywords" id="keywords" rows="5" maxlength="255" class="form-control">{{ isset($item->keywords) ? $item->keywords : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Описание</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" rows="5" maxlength="255" class="form-control">{{ isset($item->description) ? $item->description : '' }}</textarea>
                        </div>
                    </div>

                    @include('backend.common.form.action')
                </form>
            </div>
        </div>
    </div>
@endsection