@extends('layouts.backend')

@section('title', 'Пользователи')

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>Пользователи системы</h1>
        @include('backend.common.form.contextmessages')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\User())
                        <a class="btn btn-default" href="{{ url('/home/users/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить нового пользователя">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Отчество</th>
                                <th>E-mail</th>
                                <th>Создан</th>
                                <th>Обновлен</th>
                                <th class="column_text-right">Опции</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->surname ? $item->surname : '' }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->middlename ? $item->middlename : '' }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ date('h:i:s d.m.Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('h:i:s d.m.Y', strtotime($item->updated_at)) }}</td>
                                        <td class="column_text-right">
                                            @can('edit', new App\User())
                                            <a class="btn btn-info" href="{{ url('/home/users/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\User())
                                                @can('view', new App\User())
                                                <a class="btn btn-info" href="{{ url('/home/users/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                                @endcan
                                            @endcannot
                                            @can('delete', new App\User())
                                            <form action="{{ url('/home/users/'.$item->id.'/') }}" method="POST" class="form_action">
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