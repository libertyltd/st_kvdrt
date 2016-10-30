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
                      action="{{ url('/home/designs/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/designs/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="hall" class="col-sm-3 control-label">Фотография холла</label>
                        <div class="col-sm-9">
                            <input name="hall[]" id="hall" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->hall[0]) ? $item->hall[0] : '' }}"
                                   @if(!isset($item->hall[0]))
                                   required
                                    @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения не меньше 1550x1000. Поле обязательно для заполнения!</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bath" class="col-sm-3 control-label">Фотография ванной</label>
                        <div class="col-sm-9">
                            <input name="bath[]" id="bath" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->bath[0]) ? $item->bath[0] : '' }}"
                                   @if(!isset($item->bath[0]))
                                   required
                                    @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения не меньше 1300x1700. Поле обязательно для заполнения!</span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название дизайна</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lead_description" class="col-sm-3 control-label">Краткое описание дизайна (используется при выводе на главную страницу)</label>
                        <div class="col-sm-9">
                            <textarea name="lead_description" class="form-control" required>{{ isset($item->lead_description) ? $item->lead_description : '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Подробное описание дизайна</label>
                        <div class="col-sm-9">
                            <textarea name="description"
                                      id="description"
                                      class="form-control"
                                      rows="10" data-toggle="ckeditor">{!! isset($item->description) ? $item->description : '' !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-sm-3 control-label">Цена пакета от:</label>
                        <div class="col-sm-9">
                            <input name="price" id="price" class="form-control" value="{{ isset($item->price) ? $item->price : '' }}" required>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3"><span class="label label-info">Отображается на карточке дизайна НО НЕ УЧАСТВУЕТ в рассчете стоимости</span></div>
                    </div>

                    <div class="form-group">
                        <label for="price_square" class="col-sm-3 control-label">Цена за квадрат:</label>
                        <div class="col-sm-9">
                            <input name="price_square" id="price_square" class="form-control" value="{{ isset($item->price_square) ? $item->price_square : '' }}" required>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3"><span class="label label-warning">Данное значение УЧАСТВУЕТ в рассчете стоимости и ОБЯЗАТЕЛЬНО к заполнению</span></div>
                    </div>

                    <div class="form-group">
                        <label for="constant_cy" class="col-sm-3 control-label">Константа СУ:</label>
                        <div class="col-sm-9">
                            <input name="constant_cy" id="constant_cy" class="form-control" value="{{ isset($item->constant_cy) ? $item->constant_cy : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="show_in_main" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if (isset($item->show_in_main) && $item->show_in_main)
                                        active
                                @endif
                                        ">
                                    <input type="checkbox" autocomplete="off" name="show_in_main" id="show_in_main" value="1"
                                           @if (isset($item->show_in_main) && $item->show_in_main)
                                           checked
                                            @endif
                                    > Отображать на главной
                                </label>
                            </div>
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