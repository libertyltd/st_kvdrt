<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>{{isset($title) ? $title : "KVADRAT.space - ремонт за фиксированное время по фиксированной цене"}}</title>
    <link rel="shortcut icon" type="image/icon" href="/images/fav.png">
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/lightbox.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    @if(isset($scripts))
        @foreach($scripts as $script)
            <script type="text/javascript" src="{{$script}}"></script>
        @endforeach
    @endif
    <script type="text/javascript" src='/js/javascript.js'></script>
    <script type="text/javascript" src="/js/js-form.js"></script>
</head>
<body>
    @yield('content')
</body>
</html>
