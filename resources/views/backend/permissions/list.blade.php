@extends('layouts.backend')

@section('title', 'Права доступа')

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>Правила прав доступа</h1>
        @include('backend.common.form.contextmessages')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\RolePermission())
                        <a class="btn btn-default" href="{{ url('/home/permissions/add/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить право доступа">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Роль</th>
                                <th>Сущность</th>
                                <th>Действие</th>
                                <th class="column_text-right">Опции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->rp_id }}</td>
                                    <td>{{ $item->rp_role_name }}</td>
                                    <td>{{ $item->rp_entity_name }}</td>
                                    <td>
                                        <?php
                                            switch ($item->rp_action) {
                                                case 'add':
                                                    $item->rp_action = 'Добавление';
                                                    break;
                                                case 'edit':
                                                    $item->rp_action = 'Редактирование';
                                                    break;
                                                case 'view':
                                                    $item->rp_action = 'Просмотр';
                                                    break;
                                                case 'delete':
                                                    $item->rp_action = 'Удаление';
                                                    break;
                                                case 'list':
                                                    $item->rp_action = 'Просмотр списка';
                                                    break;
                                            }
                                        ?>
                                        {{ $item->rp_action }}

                                    </td>
                                    <td class="column_text-right">
                                        @can('edit', new App\RolePermission())
                                        <a class="btn btn-info" href="{{ url('/home/permissions/'.$item->rp_id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                        @endcan
                                        @can('delete', new App\RolePermission())
                                        <form action="{{ url('/home/permissions/'.$item->rp_id.'/delete/') }}" method="POST" class="form_action">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger" type="submit" data-toggle="countdown"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <?php echo $list->render(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection