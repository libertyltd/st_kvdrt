@extends('layouts.backend')

@section('title', 'Контактная информация')

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>Контактная информация для отображения на странице сайта</h1>
        <div class="alert alert-danger"><strong>Внимание!</strong> Одновременно в системе может быть активна всего одна запись!</div>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\Contact())
                        <a class="btn btn-default" href="{{ url('/home/contacts/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новую контактную запись">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        @if ($list->count() != 0)
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>E-mail</th>
                                    <th>Телефон</th>
                                    <th>Аккаунт facebook</th>
                                    <th>Аккаунт instagram</th>
                                    <th>Адрес</th>
                                    <th class="column_text-right">Опции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>
                                            @if($item->status == 0)
                                                <span class="label label-danger">{{ $item->id }}</span>
                                            @else
                                                <span class="label label-success">{{ $item->id }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ $item->phone }}
                                        </td>
                                        <td>
                                            {{ $item->facebook_link }}
                                        </td>
                                        <td>
                                            {{ $item->instagram_link }}
                                        </td>
                                        <td>
                                            {{ $item->address }}
                                        </td>
                                        <td class="column_text-right">
                                            @can('edit', new App\Contact())
                                            <a class="btn btn-info" href="{{ url('/home/contacts/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\Contact())
                                            @can('view', new App\Contact())
                                            <a class="btn btn-info" href="{{ url('/home/contacts/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\Contact())
                                            <form action="{{ url('/home/contacts/'.$item->id.'/') }}" method="POST" class="form_action">
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
                        @else
                            <div class="alert alert-info" role="alert">
                                <strong>Ни одного элемента не добавлено.</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection