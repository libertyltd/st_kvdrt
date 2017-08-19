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
                      action="{{ url('/home/type_buildings/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/type_buildings/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif



                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="additional_coefficient" class="col-sm-3 control-label">Добавочный коэффициент</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="additional_coefficient"
                                       id="additional_coefficient" value="{{ isset($item->additional_coefficient) ? $item->additional_coefficient : '' }}"
                                       aria-describedby="rub" class="form-control" data-toggle="masked-money">
                                <span class="input-group-addon" id="rub"><i class="fa fa-rub" aria-hidden="true"></i></span>
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
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('[data-toggle="masked-money"]').maskMoney({thousands:' ', decimal:'.'});
                    });
                </script>
            </div>
        </div>
    </div>
@endsection