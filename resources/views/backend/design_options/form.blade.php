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
                      action="{{ url('/home/design_options/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/design_options/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Фотография</label>
                        <div class="col-sm-9">
                            <input name="photo[]" id="photo" type="file" data-toggle="imagepicker" data-nodelete="true" data-src="{{ isset($item->photo[0]) ? $item->photo[0] : '' }}"
                                   @if(!isset($item->photo[0]))
                                   required
                                    @endif
                            >
                        </div>
                        <div class="col-sm-9 col-sm-offset-3">
                            <span class="label label-danger">Желательное разрешение изображения не меньше 1550x1000. Поле обязательно для заполнения!</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название опции</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-sm-3 control-label">Цена опции:</label>
                        <div class="col-sm-9">
                            <input name="price" id="price" class="form-control" value="{{ isset($item->price) ? $item->price : '' }}" placeholder="2345.76" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Описание:</label>
                        <div class="col-sm-9">
                            <input type="text" id="description" name="description" class="form-control" value="{{ isset($item->description) ? $item->description : '' }}" maxlength="255">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="col-sm-3 control-label">Тип опции конструктора стиля:</label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary @if (isset($item->type) && $item->type == 'room') active @endif ">
                                    <input type="radio" name="type" id="type" autocomplete="off" value="room" @if (isset($item->type) && $item->type == 'room') checked @endif> Комната
                                </label>
                                <label class="btn btn-primary @if (isset($item->type) && $item->type == 'bathroom') active @endif">
                                    <input type="radio" name="type" id="type" autocomplete="off" value="bathroom" @if (isset($item->type) && $item->type == 'bathroom') checked @endif> Ванная комната
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category_design_id" class="col-sm-3 control-label">Категория дизайна</label>
                        <div class="col-sm-9">
                            <div class="panel-group" id="designOptionList" role="tablist" aria-multiselectable="true">
                                @foreach($designs as $design)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="design{{$design->id}}">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#designOptionList" href="#designData{{$design->id}}" aria-expanded="true" aria-controls="designData{{$design->id}}">
                                                    {{ $design->name }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="designData{{$design->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="design{{$design->id}}">
                                            <div class="panel-body">
                                                @if($design->CategoryDesigns->count() > 0)
                                                <div class="btn-group" data-toggle="buttons">
                                                    @foreach($design->CategoryDesigns as $category)
                                                        <label class="btn btn-warning {{ isset($item) ? $category->id == $item->category_design_id ? 'active' : '' : ''}}">
                                                            <input type="radio" name="category_design_id" value="{{$category->id}}" {{ isset($item) ? $category->id == $item->category_design_id ? 'checked' : '' : '' }} required>
                                                            {{ $category->name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @else
                                                    <div class="alert alert-info" role="alert">
                                                        Не создано ни одной категории конструктора для данного стиля.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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