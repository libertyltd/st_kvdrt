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
                      action="{{ url('/home/feedbacks/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/feedbacks/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="avatar" class="col-sm-3 control-label">Аватар клиента</label>
                        <div class="col-sm-9">
                            <input name="avatar[]" id="avatar" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->avatar[0]) ? $item->avatar[0] : '' }}"
                                   @if(!isset($item->avatar[0]))
                                   required
                                    @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения не меньше 100x100. Поле обязательно для заполнения!</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Имя клиента</label>
                        <div class="col-sm-9">
                            <input name="name" id="mane" maxlength="255" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="text" class="col-sm-3 control-label">Текст отзыва</label>
                        <div class="col-sm-9">
                            <textarea name="text"
                                      id="text"
                                      class="form-control"
                                      rows="10" maxlength="255">{{ isset($item->text) ? $item->text : '' }}</textarea>
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