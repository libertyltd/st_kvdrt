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
                    action="{{ url('/home/users/ ') }}"
                @endif
                @if ($controllerAction === 'edit')
                    action="{{ url('/home/users/'.$idEntity.'/') }}"
                @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif

                    <div class="form-group">
                        <label for="surname" class="col-sm-3 control-label">Фамилия</label>
                        <div class="col-sm-9">
                            <input name="surname" id="surname" class="form-control" value="{{ isset($surname) ? $surname : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Имя</label>
                        <div class="col-sm-9">
                            <input name="name" id="name" class="form-control" value="{{ isset($name) ? $name : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="middlename" class="col-sm-3 control-label">Отчество</label>
                        <div class="col-sm-9">
                            <input name="middlename" id="middlename" class="form-control" value="{{ isset($middlename) ? $middlename : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">E-mail</label>
                        <div class="col-sm-9">
                            <input name="email" id="email" class="form-control" value="{{ isset($email) ? $email : ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="alert alert-info" role="alert">
                                <strong>Внимание!</strong> Для смены пароля укажите новый пароль и повторите его в соответствующем поле.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Новый пароль</label>
                        <div class="col-sm-9">
                            <input name="password" id="password" type="password" class="form-control" maxlength="255"
                            @if ($controllerAction === 'add')
                                required
                            @endif
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-3 control-label">Повторите пароль</label>
                        <div class="col-sm-9">
                            <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" maxlength="255"
                            @if ($controllerAction === 'add')
                                required
                            @endif
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="roles" class="col-sm-3 control-label">Роли пользователя</label>
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons" role="group" aria-label="roles">
                            @foreach($roles as $role)
                            <label class="btn btn-default {{ $role->active }}">
                                <input type="checkbox" name="roles[]" id="role{{ $role->name_role }}" value="{{ $role->name_role }}" autocomplete="off" {{ $role->checked }}> {{ $role->name_role }}
                            </label>
                            @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary {{ (isset($item) && $item->send_mail) ? 'active' : '' }}">
                                    <input type="checkbox" name="send_mail" autocomplete="off" {{ (isset($item) && $item->send_mail) ? 'checked' : '' }} value="1"> Отправлять уведомления о новой заявке
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