@extends('layouts.backend')

@section('title', 'Заявки на ремонт')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Заявки на ремонт</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\Order())
                        <a class="btn btn-default" href="{{ url('/home/orders/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новый заказ">
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
                                    <th>Имя клиента</th>
                                    <th>Email клиента</th>
                                    <th>Тема заявки</th>
                                    <th>Сообщение</th>
                                    <th>Статус</th>
                                    <th class="column_text-right">Опции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            {{ isset($item->name) ? $item->name : '' }}
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ isset($item->theme) ? $item->theme : '' }}
                                        </td>
                                        <td>
                                            {{ isset($item->message) ? str_limit($item->message, 20) : '' }}
                                        </td>
                                        <td>
                                            @if($item->status == 0)
                                                Новый
                                            @elseif($item->status == 1)
                                                В обработке
                                            @else
                                                Обработана
                                            @endif
                                        </td>
                                        <td class="column_text-right">
                                            @can('edit', new App\Order())
                                            <a class="btn btn-info" href="{{ url('/home/orders/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\Order())
                                            @can('view', new App\Order())
                                            <a class="btn btn-info" href="{{ url('/home/orders/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\Order())
                                            <form action="{{ url('/home/orders/'.$item->id.'/') }}" method="POST" class="form_action">
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