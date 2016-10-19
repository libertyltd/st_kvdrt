@extends('layouts.backend')

@section('title', 'Роли пользователей')

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>Роли пользователей</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\Role())
                        <a class="btn btn-default" href="{{ url('/home/roles/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новую роль">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Название роли</th>
                                <th class="column_text-right">Опции</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->name_role }}</td>
                                        <td class="column_text-right">
                                            @can('edit', new App\Role())
                                            <a class="btn btn-info" href="{{ url('/home/roles/'.$item->name_role.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\Role())
                                            @can('view', new App\Role())
                                            <a class="btn btn-info" href="{{ url('/home/roles/'.$item->name_role.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\Role())
                                            <form action="{{ url('/home/roles/'.$item->name_role.'/') }}" method="POST" class="form_action">
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
@endsection