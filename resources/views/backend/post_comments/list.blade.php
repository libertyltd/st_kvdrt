@extends('layouts.backend')

@section('title', 'Комментарии к постам')

@include('backend.homemenu')

@section ('content')
    <div class="container-fluid">
        <h1>Комментарии к постам</h1>
        @include('backend.common.form.contextmessages')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @can('add', new App\PostComment())
                        <a class="btn btn-default" href="{{ url('/home/post_comments/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новый комментарий к посту">
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
                                    <th>Автор</th>
                                    <th>Email автора</th>
                                    <th>Дата комментария</th>
                                    <th>Статья</th>
                                    <th>Ответ на комментарий</th>
                                    <th class="column_text-right">Опции</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td>
                                            {{$item->id}}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ date('d.m.Y', strtotime($item->date_create)) }}
                                        </td>
                                        <td>
                                            @can('view', new App\PostComment())
                                                <a href="{{ url('/home/posts/'.$item->post->id) }}">{{ $item->post->name }}</a>
                                            @endcan
                                            @cannot('view', new App\PostComment())
                                                {{ $item->post->name }}
                                            @endcannot
                                        </td>
                                        <td>
                                            @if($item->answer)
                                                <a href="{{ url('/home/post_comments/'.$item->answer->id) }}">от {{ date('d.m.Y', strtotime($item->date_create)) }}</a>
                                            @else
                                                <a href="{{ url('/home/post_comments/create?post_comment='.$item->id) }}" class="btn btn-success">Ответить</a>
                                            @endif
                                        </td>
                                        <td class="column_text-right">
                                            @can('edit', new App\PostComment())
                                            <a class="btn btn-info" href="{{ url('/home/post_comments/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\PostComment())
                                            @can('view', new App\PostComment())
                                            <a class="btn btn-info" href="{{ url('/home/post_comments/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                            @endcan
                                            @endcannot
                                            @can('delete', new App\PostComment())
                                            <form action="{{ url('/home/post_comments/'.$item->id.'/') }}" method="POST" class="form_action">
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