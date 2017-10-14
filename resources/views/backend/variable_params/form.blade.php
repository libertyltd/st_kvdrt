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
                      action="{{ url('/home/variable_parapms/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/variable_parapms/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Название параметра</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_amount" class="col-sm-3 control-label">Минимальное количество</label>
                        <div class="col-sm-9">
                            <input name="min_amount" class="form-control" value="{{ isset($item->min_amount) ? $item->min_amount : '0' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max_amount" class="col-sm-3 control-label">Максимальное количество</label>
                        <div class="col-sm-9">
                            <input name="max_amount" class="form-control" value="{{ isset($item->max_amount) ? $item->max_amount : '0' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default {{ isset($item->is_one) && $item->is_one ? 'active' : '' }}">
                                    <input type="checkbox" autocomplete="off" name="is_one" value="1" {{ isset($item->is_one) && $item->is_one ? 'checked' : '' }}> Только один элемент
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_per_one" class="col-sm-3 control-label">Цена за штуку</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="price_per_one"
                                       id="price_per_one" value="{{ isset($item->price_per_one) ? $item->price_per_one : '' }}"
                                       aria-describedby="rub" class="form-control" data-toggle="masked-money" required>
                                <span class="input-group-addon" id="rub"><i class="fa fa-rub" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    @if(isset($parent_id))
                        <input type="hidden" name="parent_id" value="{{$parent_id}}">
                    @endif
                    @if ($controllerAction === 'edit')
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">Связанные обязательные параметры</div>
                                <div class="panel-body">
                                    @if(isset($item) && $item->children->count() > 0)
                                        <div class="list-group">
                                        @foreach($item->children as $child)
                                            <a href="/home/variable_parapms/{{$child->id}}" target="_blank" class="list-group-item">{{ $child->name }}</a>
                                        @endforeach
                                        </div>
                                        <a href="/home/variable_parapms/create?parent={{$item->id}}" target="_blank">Создать связанный</a>
                                    @else
                                        <div class="alert alert-info">
                                            Ни одного параметра не привязано
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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