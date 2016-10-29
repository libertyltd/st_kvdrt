@extends('layouts.backend')

@section('title', 'Опции конструктора стиля')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Опции конструктора стиля</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\DesignOption())
                        <a class="btn btn-default" href="{{ url('/home/design_options/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новую категорию дизайна">
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
                                    <th>Название</th>
                                    <th>Цвет</th>
                                    <th>Цена</th>
                                    <th>Категория</th>
                                    <th>Дизайн</th>
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
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            <div style="width: 50px; height: 50px; background:#{{ $item->color }}"></div>
                                        </td>
                                        <td>
                                            {{ $item->price }}
                                        </td>
                                        <td>
                                            {{$item->CategoryDesign->name}}
                                        </td>
                                        <td>
                                            {{$item->CategoryDesign->Design->name}}
                                        </td>
                                        <td class="column_text-right">
                                            @can('edit', new App\DesignOption())
                                            <a class="btn btn-info" href="{{ url('/home/design_options/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\DesignOption())
                                            @can('view', new App\DesignOption())
                                            <a class="btn btn-info" href="{{ url('/home/design_options/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\DesignOption())
                                            <form action="{{ url('/home/design_options/'.$item->id.'/') }}" method="POST" class="form_action">
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