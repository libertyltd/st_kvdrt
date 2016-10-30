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
                      action="{{ url('/home/orders/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/orders/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Имя заказчика</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">E-mail заказчика</label>
                        <div class="col-sm-9">
                            <input name="email" type="email" id="email" class="form-control" value="{{ isset($item->email) ? $item->email : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label">Телефон</label>
                        <div class="col-sm-9">
                            <input name="phone" type="text" id="phone" class="form-control" value="{{ isset($item->phone) ? $item->phone : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="theme" class="col-sm-3 control-label">Тема обращения</label>
                        <div class="col-sm-9">
                            <input name="theme" type="text" id="theme" class="form-control" value="{{ isset($item->theme) ? $item->theme : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Сообщение</label>
                        <div class="col-sm-9">
                            <textarea id="message" name="message" rows="10" class="form-control">{{ isset($item->message) ? $item->message : '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Адрес квартиры</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" id="address" class="form-control" value="{{ isset($item->address) ? $item->address : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="apartments_type" class="col-sm-3 control-label">Тип квартиры(количество комнат)</label>
                        <div class="col-sm-9">
                            <input type="text" name="apartments_type" class="form-control" id="apartments_type" value="{{ isset($item->apartments_type) ? $item->apartments_type : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="apartments_square" class="col-sm-3 control-label">Площадь квартиры</label>
                        <div class="col-sm-9">
                            <input type="text" name="apartments_square" class="form-control" id="apartments_square" value="{{ isset($item->apartments_square) ? $item->apartments_square : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type_building_id" class="col-sm-3 control-label">Тип дома</label>
                        <div class="col-sm-9">
                            <select name="type_building_id" class="form-control" id="type_building_id">
                                <option value="">Не указан</option>
                                @foreach($typesBuilding as $typeBuilding)
                                    <option value="{{ $typeBuilding->id }}" {{$typeBuilding->selected}}>{{ $typeBuilding->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type_bathroom_id" class="col-sm-3 control-label">Тип санузла</label>
                        <div class="col-sm-9">
                            <select name="type_bathroom_id" class="form-control" id="type_bathroom_id">
                                <option value="">Не указан</option>
                                @foreach($typesBathroom as $typeBathroom)
                                    <option value="{{ $typeBathroom->id }}" {{$typeBathroom->selected }}>{{ $typeBathroom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Дизайн</label>
                        <div class="col-sm-9"  id="designs_switcher">
                            <input type="hidden" name="design_id" value="{{ isset($item->design_id) ? $item->design_id : '' }}">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($designs as $design)
                                <li role="presentation" class="{{ isset($item->design_id) ? $item->design_id == $design->id ? 'active' : '' : '' }}">
                                    <a href="#design{{$design->id}}" aria-controls="design{{$design->id}}" role="tab" data-toggle="tab" data-name="design_id" data-value="{{$design->id}}">
                                        {{ $design->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach($designs as $design)
                                    <div role="tabpanel" class="tab-pane {{ isset($item->design_id) ? $item->design_id == $design->id ? 'active' : '' : '' }}" id="design{{$design->id}}">
                                        @foreach($design->CategoryDesigns as $category)
                                            <h3><span class="label label-info">{{$category->name}}</span></h3>
                                            <div class="btn-group-vertical" role="group" data-toggle="buttons">
                                                @foreach($category->DesignOptions as $option)
                                                    <label class="btn btn-default
                                                    @if(isset($item))
                                                    @foreach($item->DesignOptions as $do)
                                                    {{ $do->id == $option->id ? 'active' : '' }}
                                                    @endforeach
                                                    @endif
                                                    ">
                                                        <input type="checkbox" name="design_option_id[]" autocomplete="off" value="{{ $option->id }}"
                                                        @if(isset($item))
                                                            @foreach($item->DesignOptions as $do)
                                                                {{ $do->id == $option->id ? 'checked' : '' }}
                                                            @endforeach
                                                        @endif
                                                        >
                                                        {{ $option->name }} ({{\App\Design::formatPrice($option->price)}} руб.)
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Дополнительные опции</label>
                        <div class="col-sm-9">
                            <div class="btn-group-vertical" role="group" data-toggle="buttons">
                                @foreach($options as $option)
                                    <label class="btn btn-warning {{$option->active}}">
                                        <input type="checkbox" name="option_id[]" autocomplete="off" {{isset($option->active) ? 'checked' : ''}} value="{{$option->id}}">
                                        {{ $option->name }} ({{ \App\Design::formatPrice($option->price) }} руб.)
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Статус заявки</label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-success {{ isset($item->status) ? $item->status == 0 ? 'active' : '' : '' }}">
                                    <input type="radio" name="status" value="0" autocomplete="off" {{ isset($item->status) ? $item->status == 0 ? 'checked' : '' : '' }}> Новая
                                </label>
                                <label class="btn btn-warning {{ isset($item->status) ? $item->status == 1 ? 'active' : '' : '' }}">
                                    <input type="radio" name="status" value="1" autocomplete="off" {{ isset($item->status) ? $item->status == 1 ? 'checked' : '' : '' }}> В работе
                                </label>
                                <label class="btn btn-danger {{ isset($item->status) ? $item->status == 2 ? 'active' : '' : '' }}">
                                    <input type="radio" name="status" value="2" autocomplete="off" {{ isset($item->status) ? $item->status == 2 ? 'checked' : '' : '' }}> Завершена
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