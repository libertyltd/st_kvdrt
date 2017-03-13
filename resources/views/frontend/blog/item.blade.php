@extends('layouts.app')
@section('content')
    @include('frontend.fragments.first_step_form')
    @include('frontend.fragments.header')
    <div class="container">
        <div class="blog__header">
            <img class="blog__header__cover" src="{{ $item->cover[0] }}">
            <div class="blog__header__title">
                <h1 class="blog__title">{{ $item->name }}</h1>
                <div class="blog__time-publication">{{ $item->getHumanDatePublication() }}</div>
                <p class="blog__lead">{{ $item->lead }}</p>
            </div>
        </div>
        <div class="blog__content">
            {!! $item->description !!}
        </div>
        <div class="blog__social">
            <script type="text/javascript">(function() {
                    if (window.pluso)if (typeof window.pluso.start == "function") return;
                    if (window.ifpluso==undefined) { window.ifpluso = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                        s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                        var h=d[g]('body')[0];
                        h.appendChild(s);
                    }})();</script>
            <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email"></div>
        </div>
    </div>
    <div class="blog__comment-form">
        <div class="container">
            <form class="blog__comment-form__input-place" id="form_comment" method="post">
                {{ csrf_field() }}
                @if($errors)
                    @foreach($errors as $error)
                        <div class="blog__comment-form__errors">{{ $error }}</div>
                    @endforeach
                @endif
                <h3 class="blog__comment-form__title">Оставить комментарий:</h3>
                <input class="blog__comment-form__control" name="name" type="text" placeholder="Имя" value="{{ old('name') }}">
                <input class="blog__comment-form__control" name="email" type="email" placeholder="Email" value="{{ old('email') }}">
                <div class="blog__comment-form__capcha">
                    <img class="blog__comment-form__capcha__img" src="{{ $capcha }}">
                    <input class="blog__comment-form__capcha__input" name="capcha" type="text" placeholder="Код" value="{{ old('capcha') }}">
                </div>
                <textarea name="message" class="blog__comment-form__message" rows="10" placeholder="Сообщение">{{ old('message') }}</textarea>
                <div class="blog__comment-form__submit">
                    <button class="btn btn-info" type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </div>
    <div class="comment__list">
        <div class="container">
            @foreach($comments as $comment)
                <div class="comment__item">
                    <div class="comment__item__name">{{ $comment->name }}</div>
                    <div class="comment__item__date">{{ date('d.m.Y', strtotime($comment->date_create)) }}</div>
                    <div class="comment__item__message">
                        {{ $comment->message }}
                    </div>
                </div>
                @if($comment->answer)
                    <div class="comment__item comment__item_answer">
                        <div class="comment__item__name">{{ $comment->answer->name }}</div>
                        <div class="comment__item__date">{{ date('d.m.Y', strtotime($comment->answer->date_create)) }}</div>
                        <div class="comment__item__message">
                            {{ $comment->answer->message }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="container">
        <h3 class="last-news__title">Последние новости:</h3>
        <div class="blog_list">
            <div class="blog_list-item__zero"></div>
            @foreach($lastNews as $new)
                <div class="blog_list-item {{ $new->class }}">
                    <img class="blog_list-item__cover" src="{{ $new->cover[0] }}">
                    <div class="blog_list-item__description">
                        <a href="{{ url('/blog/'.$new->id) }}" class="blog_list-item__title">{{ $new->name }}</a>
                        <div class="blog_list-item__time_publication">{{ $new->getHumanDatePublication() }}</div>
                        <div class="blog_list-item__lead">{{ $new->lead }}</div>
                        <div class="blog_list-item__btn">
                            <a class="btn btn-default" href="{{url('/blog/'.$new->id)}}" rel="nofollow">Подробнее</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('frontend.fragments.footer')
@endsection