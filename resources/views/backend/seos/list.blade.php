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
                        @can('add', new App\SEO())
                            <a class="btn btn-default" href="{{ url('/home/seos/create/') }}" data-toggle="tooltip" data-placement="bottom" title="Добавить новые данные">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </div>
                    <div class="panel-body">
                        @if ($list->count() != 0)
                            <table class="table table-striped table-hover">
                                <div class="row">
                                    <div class="col-sm-2">#</div>
                                    <div class="col-sm-3">URL</div>
                                    <div class="col-sm-3">Aliace</div>
                                    <div class="col-sm-4"></div>
                                </div>
                                @foreach($list as $item)
                                    <div class="row">
                                        <div class="col-sm-2">{{ $item->id }}</div>
                                        <div class="col-sm-3">{{ $item->original_url }}</div>
                                        <div class="col-sm-3">{{ $item->alias_url }}</div>
                                        <div class="col-sm-4">
                                            @can('edit', new App\SEO())
                                                <a class="btn btn-info" href="{{ url('/home/seos/'.$item->id.'/edit/') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</a>
                                            @endcan
                                            @cannot('edit', new App\SEO())
                                                @can('view', new App\SEO())
                                                    <a class="btn btn-info" href="{{ url('/home/seos/'.$item->id.'/') }}"><i class="fa fa-eye" aria-hidden="true"></i> Показать</a>
                                                @endcan
                                            @endcannot
                                            @can('delete', new App\SEO())
                                                <form action="{{ url('/home/seos/'.$item->id.'/') }}" method="POST" class="form_action">
                                                    {{ csrf_field() }}
                                                    {{ method_field('UPDATE') }}
                                                    <input type="hidden" name="status" value="0">
                                                    <button class="btn btn-danger" type="submit" data-toggle="countdown"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                </form>
                                            @endcan
                                        </div>

                                    </div>
                                @endforeach

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