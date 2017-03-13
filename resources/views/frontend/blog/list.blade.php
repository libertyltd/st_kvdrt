@extends('layouts.app')
@section('content')
    @include('frontend.fragments.first_step_form')
    @include('frontend.fragments.header')
    <div class="container">
        @if($list)
            <div class="blog_list">
                @foreach($list as $item)
                    <div class="blog_list-item {{$item->class}}">
                        <img class="blog_list-item__cover" src="{{ $item->cover[0] }}">
                        <div class="blog_list-item__description">
                            <a href="{{ url('/blog/'.$item->id) }}" class="blog_list-item__title">{{ $item->name }}</a>
                            <div class="blog_list-item__time_publication">{{ $item->getHumanDatePublication() }}</div>
                            <div class="blog_list-item__lead">{{ $item->lead }}</div>
                            <div class="blog_list-item__btn">
                                <a class="btn btn-default" href="{{ url('/blog/'.$item->id) }}" rel="nofollow">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav class="pagination_place">
                {{ $list->render() }}
                <!--
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li class="active"><span>3</span></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>-->
            </nav>
        @else
        @endif
    </div>
    @include('frontend.fragments.footer')
@endsection