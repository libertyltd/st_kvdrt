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
                <form class="form-horizontal" method="POST"
                      @if ($controllerAction === 'add')
                      action="{{ url('/home/textonvideo/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/textonvideo/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif
                    <div class="form-group">
                        <label for="text" class="col-sm-3 control-label">Текст на видео</label>
                        <div class="col-sm-9">
                            <input type="text" name="text" id="text" class="form-control"
                                   value="{{isset($item->text) ? $item->text : ''}}"
                                   @if($controllerAction == 'add')
                                        required
                                   @endif>
                        </div>
                    </div>
                    @include('backend.common.form.action')
                </form>
            </div>
        </div>

    </div>
@endsection