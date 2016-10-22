@extends('layouts.backend')

@section('title', 'Выполненный работы')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Выполненные работы</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\Work())
                        <a class="btn btn-default" href="{{ url('/home/works/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новую выполненную работу">
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
                                    <th>Миниатюра</th>
                                    <th>Название</th>
                                    <th>Метраж в м<sup>2</sup></th>
                                    <th>Описание</th>
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
                                            @if(isset($item->miniatureSrc[0]))
                                                <img src="{{ $item->miniatureSrc[0] }}">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->square }}
                                        </td>
                                        <td>
                                            {{ str_limit($item->description, 20) }}
                                        </td>
                                        <td class="column_text-right">
                                            @can('edit', new App\Work())
                                            <a class="btn btn-info" href="{{ url('/home/works/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\Work())
                                            @can('view', new App\Work())
                                            <a class="btn btn-info" href="{{ url('/home/works/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\Work())
                                            <form action="{{ url('/home/works/'.$item->id.'/') }}" method="POST" class="form_action">
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