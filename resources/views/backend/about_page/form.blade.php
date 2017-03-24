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
                      action="{{ url('/home/about_page/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/about_page/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Описание:</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" id="description" row="15" data-toggle="ckeditor">{!! isset($item->description) ? $item->description : '' !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description_img" class="col-sm-3 control-label">Изображения используемые в описании:</label>
                        <div class="col-sm-9">
                            <input name="description_img[]" id="description_img" type="file" data-toggle="imagepickermult" accept="image/*" multiple
                                   data-upload-images="@if(isset($item)) @foreach($item->description_img as $gal){{ $gal }},@endforeach @endif"
                                   data-upload-images-orig="@if(isset($item)) @foreach($item->description_img_src as $gal){{ $gal }},@endforeach @endif"
                                   data-target = "description"
                            >
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