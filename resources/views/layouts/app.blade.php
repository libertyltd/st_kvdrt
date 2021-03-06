<!DOCTYPE html>
<html lang="ru" prefix="og: http://kvadrat.space/#">
<head>
    <meta charset="utf-8">
    @if(isset($class) && $class=='gen')
    <meta name="viewport" content="width=1400">
    @else
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @endif
    <title>{{isset($title) ? $title : "KVADRAT.space - ремонт за фиксированное время по фиксированной цене"}}</title>
    <meta property="og:title" content="{{isset($title) ? $title : "KVADRAT.space - ремонт за фиксированное время по фиксированной цене"}}" />
    <meta property="og:image" content="http://kvadrat.space/images/logo.png" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="KVADRAT.space - ремонт за фиксированное время по фиксированной цене" />
    @if(isset($keywords))
    <meta name="keywords" content="{{$keywords}}" />
    @endif


    @if(isset($description))
    <meta name="description" content="{{$description}}" />
    @endif

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
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40787559 = new Ya.Metrika({ id:40787559, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40787559" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-87082779-1', 'auto');
        ga('send', 'pageview');

    </script>
    @yield('content')
    <!-- BEGIN JIVOSITE CODE {literal} -->
        <script type='text/javascript'>
        (function(){ var widget_id = 'Yq0k4rC6GU';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
    <!-- {/literal} END JIVOSITE CODE -->
</body>
</html>
