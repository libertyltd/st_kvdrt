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
                <form class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="rp_role_name" class="col-sm-3 control-label">Роль пользователя</label>
                        <div class="col-sm-9">
                            <select name="rp_role_name" id="rp_role_name" class="form-control" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name_role }}" {{ $role->select }}>{{ $role->name_role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rp_entity_name" class="col-sm-3 control-label">Сущность</label>
                        <div class="col-sm-9">
                            <input name="rp_entity_name" id="rp_entity_name" class="form-control" value="{{ isset($rp_entity_name) ? $rp_entity_name : '' }}" placeholder="App\User" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rp_action" class="col-sm-3 control-label">Действие</label>
                        <div class="col-sm-9">
                            <select name="rp_action" id="rp_action" class="form-control" required>
                                @foreach($actions as $action)
                                    <option value="{{ $action['name'] }}" {{ $action['select'] }}>{{ $action['description'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @include('backend.common.form.action')
                </form>
            </div>
        </div>

    </div>
@endsection

