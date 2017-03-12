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
                      action="{{ url('/home/posts/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/posts/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="alert alert-info"><strong>Внимание!</strong><br> Информация по тегам title, description, keywords, а так же псевдонимам адреса текущей страницы указывается в разделе <a href="{{url('/home/seos/')}}">SEO</a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="alert alert-warning"><strong>Внимание!</strong><br> Публикая будет отображена на сайте, если текущая дата больше либо равна дате публикации и статус записи активен.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_publication" class="col-sm-3 control-label">Дата публикации</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="date_publication">
                                <input type="text" class="form-control" name="date_publication" aria-label="Дата публикации" value="{{ isset($item->date_publication)? date('d-m-Y', strtotime($item->date_publication)) : '' }}" required>
                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#date_publication').datetimepicker({
                                locale:'ru',
                                format: 'DD-MM-YYYY',
                                date: null,
                                {!! isset($item->date_publication)? 'defaultDate:"'.date('d-m-Y', strtotime($item->date_publication)).'",' : '' !!}
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label for="lead" class="col-sm-3 control-label">Лид:</label>
                        <div class="col-sm-9">
                            <textarea name="lead" class="form-control" id="lead" row="8" maxlength="255" required>{{ isset($item->lead) ? $item->lead : ''}}</textarea>
                        </div>
                    </div>
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