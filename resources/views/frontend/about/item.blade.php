@extends('layouts.app')
@section('content')
    @include('frontend.fragments.first_step_form')
    @include('frontend.fragments.header')
    <div class="container" style="margin-top: 40px;">
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
    @include('frontend.fragments.footer')
@endsection