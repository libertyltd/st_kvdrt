<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>


    <!-- Scripts -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
    @if (isset($scripts))
        @foreach($scripts as $script)
            <script type="text/javascript" src="{{ $script }}"></script>
        @endforeach
    @endif
    <script type="text/javascript" src="/js/backend.js"></script>

    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/backend.css">

</head>
<body id="backendLayout">
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                <span class="sr-only">Показать меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{ url('/') }}">
                Kvadrat.space
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    @yield('backendmenu')
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home') }}"><i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;Рабочий стол</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>&nbsp;Выход</a></li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>



    </div>
</nav>

@yield('content')
</body>
</html>