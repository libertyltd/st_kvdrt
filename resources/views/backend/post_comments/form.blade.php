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
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                      @if ($controllerAction === 'add')
                      action="{{ url('/home/post_comments/ ') }}"
                      @endif
                      @if ($controllerAction === 'edit')
                      action="{{ url('/home/post_comments/'.$idEntity.'/') }}"
                        @endif
                >
                    {{ csrf_field() }}
                    @if ($controllerAction === 'edit')
                        {{ method_field('PUT') }}
                    @endif
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Автор:</label>
                        <div class="col-sm-9">
                            <input name="name" type="text" id="name" class="form-control" value="{{ isset($item->name) ? $item->name : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">E-mail автора:</label>
                        <div class="col-sm-9">
                            <input name="email" id="email" class="form-control" type="email" value="{{ isset($item->email) ? $item->email : '' }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_publication" class="col-sm-3 control-label">Дата создания комментария:</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="date_publication">
                                <input type="text" class="form-control" name="date_create" aria-label="Дата публикации" value="{{ isset($item->date_create)? date('d-m-Y', strtotime($item->date_create)) : '' }}" required>
                                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#date_publication').datetimepicker({
                                locale:'ru',
                                format: 'DD-MM-YYYY',
                                date: null,
                                {!! isset($item->date_create)? 'defaultDate: new Date('.date('Y', strtotime($item->date_create)).', '.(date('m', strtotime($item->date_create))-1).','.date('d', strtotime($item->date_create)).'),' : '' !!}
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Текст сообщения:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="message" id="message" rows="10" required>{{ isset($item->message) ? $item->message : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="post_id" class="col-sm-3 control-label">Пост:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="post_id" {{ isset($item->post_comment_id) && $item->post_comment_id ? 'disabled' : '' }} {{ isset($parent_comment) ? 'disabled' : ''}}>
                                @if(isset($parent_comment) && $parent_comment)
                                    <option value="{{ \App\PostComment::find($parent_comment)->post->id }}">{{date('d-m-Y', strtotime(\App\PostComment::find($parent_comment)->post->date_publication))}} {{ \App\PostComment::find($parent_comment)->post->name }} </option>
                                @else
                                    @if(isset($posts) && $posts->count())
                                        @foreach($posts as $post)
                                            @if(isset($item) && ($post->id == $item->post_id))
                                                <option value="{{$post->id}}" selected>{{ isset($post->date_publication)? date('d-m-Y', strtotime($post->date_publication)) : '' }} {{ $post->name }}</option>
                                            @else
                                                <option value="{{$post->id}}">{{ isset($post->date_publication)? date('d-m-Y', strtotime($post->date_publication)) : '' }} {{ $post->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option selected disabled>В системе нет ни одного поста</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                    @if(isset($item) && $item->answer)
                        <div class="form-group">
                            <h3 class="col-sm-offset-3 col-sm-9">Ответ на комментарий:</h3>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"><strong>{{ $item->answer->name }}</strong> - {{ isset($item->answer->date_create)? date('d-m-Y', strtotime($item->answer->date_create)) : '' }}</div>
                            <div class="col-sm-9">{{ $item->answer->message }}</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="{{ url('/home/post_comments/'.$item->answer->id.'/edit') }}" class="btn btn-info">Перейти к комментарию</a>
                            </div>
                        </div>
                    @else
                        @if(isset($item) && !$item->post_comment_id)
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="{{ url('/home/post_comments/create?post_comment='.$item->id) }}" class="btn btn-success">Ответить на комментарий</a>
                            </div>
                        </div>
                        @endif
                    @endif
                    @if (isset($parent_comment))
                        <input type="hidden" name="post_comment_id" value="{{ $parent_comment }}">
                    @endif
                    @include('backend.common.form.action')
                </form>
            </div>
        </div>
    </div>
@endsection