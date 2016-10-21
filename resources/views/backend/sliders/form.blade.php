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
                      action="{{ url('/home/sliders/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/sliders/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Изображение слайда</label>
                        <div class="col-sm-9">
                            <input name="image[]" id="image" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->image[0]) ? $item->image[0] : '' }}"
                                   @if(!isset($item->image[0]))
                                   required
                                   @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения не меньше 1365x807. Поле обязательно для заполнения!</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="promo_text" class="col-sm-3 control-label">Текст на слайде</label>
                        <div class="col-sm-9">
                            <input name="promo_text" id="promo_text" class="form-control" value="{{ isset($item->promo_text) ? $item->promo_text : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="show_button" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if (isset($item->show_button) && $item->show_button)
                                        active
                                @endif
                                        ">
                                    <input type="checkbox" autocomplete="off" name="show_button" id="show_button" value="1"
                                           @if (isset($item->show_button) && $item->show_button)
                                           checked
                                            @endif
                                    > Отображать кнопку перехода
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="button_text" class="col-sm-3 control-label">Текст на кнопке перехода</label>
                        <div class="col-sm-9">
                            <input name="button_text" maxlength="20" id="button_text" class="form-control" value="{{ isset($item->button_text) ? $item->button_text : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="button_link" class="col-sm-3 control-label">Ссылка кнопки перехода</label>
                        <div class="col-sm-9">
                            <input name="button_link" maxlength="255" id="button_link" class="form-control" value="{{ isset($item->button_link) ? $item->button_link : '' }}">
                        </div>
                        <div class="col-sm-9 col-sm-offset-3"><span class="label label-info">Для перехода не сторонний ресурс (http://example.com), для внутренних страниц (/some/page/)</span></div>
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