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
                      action="{{ url('/home/contacts/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/contacts/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Контактный Email</label>
                        <div class="col-sm-9">
                            <input name="email" id="email" class="form-control" value="{{ isset($email) ? $email : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label">Контактный телефон</label>
                        <div class="col-sm-9">
                            <input name="phone" id="phone" class="form-control" value="{{ isset($phone) ? $phone : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="facebook" class="col-sm-3 control-label">Ссылка на профиль в Facebook</label>
                        <div class="col-sm-9">
                            <input name="facebook_link" id="facebook" class="form-control" value="{{ isset($facebook_link) ? $facebook_link : ''}}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instagram" class="col-sm-3 control-label">Ссыка на проиль в Instagram</label>
                        <div class="col-sm-9">
                            <input name="instagram_link" id="instagram" class="form-control" value="{{ isset($instagram_link) ? $instagram_link : '' }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Адрес</label>
                        <div class="col-sm-9">
                            <input name="address" id="address" class="form-control" value="{{ isset($address) ? $address : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="longitude" class="col-sm-3 control-label">Долгота (Google карты)</label>
                        <div class="col-sm-9">
                            <input name="longitude" id="longitude" class="form-control" value="{{ isset($longitude) ? $longitude : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="latitude" class="col-sm-3 control-label">Широта (Google карты)</label>
                        <div class="col-sm-9">
                            <input name="latitude" id="latitude" class="form-control" value="{{ isset($latitude) ? $latitude : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Статус записи</label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if (isset($status) && $status)
                                        active
                                @endif
                                        ">
                                    <input type="checkbox" autocomplete="off" name="status" id="status" value="1"
                                           @if (isset($status) && $status)
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