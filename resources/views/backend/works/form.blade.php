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
                      action="{{ url('/home/works/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/works/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Главное изображение работы</label>
                        <div class="col-sm-9">
                            <input name="image[]" id="image" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->image[0]) ? $item->image[0] : '' }}"
                                   @if(!isset($item->image[0]))
                                   required
                                    @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения пропорциональное 340x224. Поле обязательно для заполнения!</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название помещения с указанием метража </label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="square" class="col-sm-3 control-label">Метраж помещения через "," десятые доли</label>
                        <div class="col-sm-9">
                            <input name="square" id="square" class="form-control" value="{{ isset($item->square) ? $item->square : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Описание проделланных работ</label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" class="form-control" rows="10">{{ isset($item->description) ? $item->description : '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Статус записи</label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if (isset($item->status) && $item->status)
                                        active
                                @endif
                                        ">
                                    <input type="checkbox" autocomplete="off" name="status" id="status" value="1"
                                           @if (isset($item->status) && $item->status)
                                           checked
                                            @endif
                                    > <i class="fa fa-power-off" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    @include('backend.common.form.action')
                </form>
            </div>
        </div>
    </div>
@endsection