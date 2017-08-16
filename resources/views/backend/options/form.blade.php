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
                      action="{{ url('/home/options/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/options/'.$idEntity.'/') }}"
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
                        <label for="price" class="col-sm-3 control-label">Цена</label>
                        <div class="col-sm-9">
                            <input name="price" id="price" class="form-control" value="{{ isset($item->price) ? $item->price : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if(isset($item->is_dynamic_calculate) && $item->is_dynamic_calculate)
                                        active
                                @endif
                                ">
                                    <input type="checkbox" autocomplete="off" name="is_dynamic_calculate" id="is_dynamic_calculate"
                                           value="1" @if(isset($item->is_dynamic_calculate) && $item->is_dynamic_calculate) checked @endif>
                                    Динамический рассчет стоимости
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_per_meter" class="col-sm-3 control-label">Сумма за квадратный метр</label>
                        <div class="col-sm-9">
                            <input name="price_per_meter" id="price_per_meter" class="form-control" value="{{ isset($item->price_per_meter) ? $item->price_per_meter : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="minimal_dynamic_price" class="col-sm-3 control-label">Минимальная сумма за услугу</label>
                        <div class="col-sm-9">
                            <input name="minimal_dynamic_price" id="minimal_dynamic_price" class="form-control" value="{{ isset($item->minimal_dynamic_price) ? $item->minimal_dynamic_price : '' }}">
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
                        function disabledDynamicCalcFields () {
                            var $pricePerMeter = $('#price_per_meter');
                            var $minPrice = $('#minimal_dynamic_price');
                            $pricePerMeter.attr('disabled', 'disabled');
                            $minPrice.attr('disabled','disabled');
                            $pricePerMeter.attr('required', 'required');
                            $minPrice.attr('required', 'required');
                        }

                        function enabledDynamicCalcFields () {
                            var $pricePerMeter = $('#price_per_meter');
                            var $minPrice = $('#minimal_dynamic_price');
                            $pricePerMeter.removeAttr('disabled');
                            $minPrice.removeAttr('disabled');
                            $pricePerMeter.removeAttr('required');
                            $minPrice.removeAttr('required');
                        }

                        var $isDynamicCalc = $('#is_dynamic_calculate');
                        if ($isDynamicCalc.prop('checked')) {
                            enabledDynamicCalcFields();
                        } else {
                            disabledDynamicCalcFields();
                        }

                        $isDynamicCalc.bind('change', function () {
                            if ($(this).prop('checked')) {
                                enabledDynamicCalcFields();
                            } else {
                                disabledDynamicCalcFields();
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection