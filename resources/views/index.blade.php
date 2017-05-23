@extends('layouts.app')

@section('content')
    <div class="page">
        @include('frontend.fragments.first_step_form')
        @include('frontend.fragments.header')
        @if (isset($slides))
        <div class="hero">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                    <div class="swiper-slide" style="background-image: url('{!! $slide->src !!}');">
                        <div class="slide-content">
                            <div class="hero-head">
                                {{ $slide->promo_text }}
                            </div>
                            @if($slide->show_button)
                            <div class="conf-btn">
                                <a href="{{ isset($slide->button_link) ? $slide->button_link : '#' }}" class="add_cont">{{ $slide->button_text }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        @endif
        <div class="about">
            <div class="reg-content">
                Ремонтируем по готовому дизайн-проекту.<br>
                Обновим интерьер в сжатые сроки и за фиксированную стоимость.
            </div>
        </div>
        <div class="features">
            <div class="tabs">
                <ul class="tab-links">
                    <li class="active advantage"><a href="#tab1"><img src="/images/_0014_arrow-right.png" alt="">Преимущества</a></li>
                    <!--<li><a href="#tab2">Этапы работы<img src="/images/_0013_arrow-left.png" alt=""></a></li>-->
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab active">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0025_icon1.png" alt="">
                            </div>
                            <div class="feature-text">
                                БЕЗ ГОЛОВНОЙ БОЛИ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0027_icon-2.png" alt="">
                            </div>
                            <div class="feature-text">
                                ГАРАНТИЯ СРОКОВ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0024_icon-3.png" alt="">
                            </div>
                            <div class="feature-text">
                                ЦЕНА НИЖЕ РЫНОЧНОЙ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0026_icon-4.png" alt="">
                            </div>
                            <div class="feature-text">
                                ДИЗАЙНЕРСКИЙ РЕМОНТ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0022_icon-5.png" alt="">
                            </div>
                            <div class="feature-text">
                                ИННОВАЦИОННЫЕ ИДЕИ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0023_icon-6.png" alt="">
                            </div>
                            <div class="feature-text">
                                СТРАХОВКА
                            </div>
                        </div>
                        <div class="count">
                            <a href="#" class='add_cont'>Рассчитать</a>
                        </div>
                    </div>
                    <div id="tab2" class="tab">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0021_icon-6.png" alt="">
                            </div>
                            <div class="feature-text">
                                КОНФИГУРАТОР НА САЙТЕ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0020_icon-7.png" alt="">
                            </div>
                            <div class="feature-text">
                                ВСТРЕЧА С ГЛАВНЫМ ИНЖЕНЕРОМ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0019_icon-8.png" alt="">
                            </div>
                            <div class="feature-text">
                                ПОДПИСАНИЕ ДОГОВОРА/ПЕРЕДАЧА КЛЮЧЕЙ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0018_icon-9.png" alt="">
                            </div>
                            <div class="feature-text">
                                ремонт
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0017_icon-10.png" alt="">
                            </div>
                            <div class="feature-text">
                                сдача
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0016_icon-11.png" alt="">
                            </div>
                            <div class="feature-text">
                                заселение
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='clearbox'></div>
        <div class="design" id="design">
            <div class="lg-head">
                Дизайн
            </div>
            <div class="reg-content">
                Всерьез задумали изменить интерьер? Мы поможем определиться с новыми цветами, текстурами и аксессуарами. Соберите собственный дизайн с помощью конструктора или выберите уже готовый вариант. Ваша идея - наша реализация!
            </div>
        </div>
        @if (isset($designs))
        <div class="design-style">
            @foreach($designs as $design)
                @if($design->side == 'left')
                    <div class="design-row">
                        <div class="row-left">
                            <a class="example-image-link" href="{{ $design->hall[0] }}" data-lightbox="example-set1" data-title="{{ $design->description }}">
                                <img src="{{ $design->hallMin[0] }}" class="lg-img-row" alt="{{ $design->name }}">

                            </a>
                            <a class="example-image-link" href="{{ $design->bath[0] }}" data-lightbox="example-set1" data-title="{{ $design->description }}">
                                <img src="{{ $design->bathMin[0] }}" class="sm-img-row" alt="{{ $design->name }}">

                            </a>
                        </div>
                        <div class="row-right">
                            <div class="design-description">
                                <div class="design-head">
                                    {{ $design->name }}
                                </div>
                                <div class="design-price">
                                    <span>от</span>
                                    <span>{{ $design->price }}</span>
                                    <span>р</span>
                                </div>
                                <div class="design-description-main">
                                    {{ $design->lead_description }}
                                </div>
                            </div>
                        </div>
                        <div class="clearbox"></div>
                    </div>
                @else
                    <div class="design-row">
                        <div class="row-left">
                            <div class="design-description right-align">
                                <div class="design-head">
                                    {{ $design->name }}
                                </div>
                                <div class="design-price">
                                    <span>от</span>
                                    <span>{{ $design->price }}</span>
                                    <span>р</span>
                                </div>
                                <div class="design-description-main">
                                    {{ $design->lead_description }}
                                </div>
                            </div>
                        </div>
                        <div class="row-right">
                            <a class="example-image-link" href="{{ $design->hall[0] }}" data-lightbox="example-set1" data-title="{{ $design->description }}">
                                <img src="{{ $design->hallMin[0] }}" class="lg-img-row" alt="{{ $design->name }}">

                            </a>
                            <a class="example-image-link" href="{{ $design->bath[0] }}" data-lightbox="example-set1" data-title="{{ $design->description }}">
                                <img src="{{ $design->bathMin[0] }}" class="sm-img-row" alt="{{ $design->name }}">

                            </a>
                        </div>
                        <div class="clearbox"></div>
                    </div>
                @endif
            @endforeach
        </div>
        @endif
        <div class="features">
            <div class="tabs">
                <ul class="tab-links">
                    <li class="active advantage"><a href="#tab1"><img src="/images/_0014_arrow-right.png" alt="">Этапы работы</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab active">
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0021_icon-6.png" alt="">
                            </div>
                            <div class="feature-text">
                                КОНФИГУРАТОР НА САЙТЕ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0020_icon-7.png" alt="">
                            </div>
                            <div class="feature-text">
                                ВСТРЕЧА С ГЛАВНЫМ ИНЖЕНЕРОМ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0019_icon-8.png" alt="">
                            </div>
                            <div class="feature-text">
                                ПОДПИСАНИЕ ДОГОВОРА/ПЕРЕДАЧА КЛЮЧЕЙ
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0018_icon-9.png" alt="">
                            </div>
                            <div class="feature-text">
                                ремонт
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0017_icon-10.png" alt="">
                            </div>
                            <div class="feature-text">
                                сдача
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-img">
                                <img src="/images/_0016_icon-11.png" alt="">
                            </div>
                            <div class="feature-text">
                                заселение
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='clearbox'></div>
        <div class="partners" id="partners">
            <div class="lg-head">
                Наши партнеры
            </div>
            <div class="partners-grid first">
                <div class="partners-grid-col">
                    <img src="/images/partner-1.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-2.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-3.jpg">
                </div>
            </div>
            <div class="partners-grid">
                <div class="partners-grid-col">
                    <img src="/images/partner-4.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-5.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-6.jpg">
                </div>
            </div>
            <div class="partners-grid">
                <div class="partners-grid-col">
                    <img src="/images/partner-7.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-8.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-9.jpg">
                </div>
            </div>
            <div class="partners-grid">
                <div class="partners-grid-col">
                    <img src="/images/partner-10.jpg">
                </div>
                <div class="partners-grid-col">
                    <img src="/images/partner-11.jpg">
                </div>
                <div class="partners-grid-col">

                </div>
            </div>
        </div>
        @if (isset($feedbacks))
        <div class="feedback">
            <div class="lg-head">
                отзывы
            </div>
            <div class="swiper-container2">
                <div class="swiper-wrapper">
                    @foreach ($feedbacks as $feedback)
                    <div class="swiper-slide">
                        <div class="feedback-img">
                            <img src="{{ $feedback->avatar }}" alt="{{ $feedback->name }}">
                        </div>
                        <div class="feedback-response">
                            {{ $feedback->text }}
                            <a href="">{{ $feedback->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($feedbacks->count() > 1)
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                @endif
                <!-- Add Pagination -->
                <div class="swiper-pagination2"></div>
            </div>
        </div>
        @endif
        @if(isset($works))
            <div class='gallery-block'>
                @if(isset($workDescription))
                    <div class="reg-content" style="text-align:center; margin-bottom: 20px;">
                        {{ $workDescription->description }}
                    </div>
                @endif
                <div class='gallery'>
                    @foreach($works as $item)
                    <div class='gal-item'>
                        <a class="example-image-link" href="{{ $item->origSrc[0] }}" data-lightbox="example-set" data-title="<span class='title-head'>{{ $item->name }}</span><br> <span class='title-main'>{{ $item->description }}</span>">
                            <img class="example-image" src="{{ $item->miniSrc[0] }}" alt="{{ $item->name }}"/>
                            <div class='gal-desc'>
                                <div class='gal-desc-head'>
                                    {{ $item->name }}
                                </div>
                                <div class='gal-desc-content'>
                                    {{ $item->description }}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class='clearbox'></div>
        <div class="contacts" id="contacts">
            <div class="contacts-content">
                <div class="contant-form">
                    <form action="/constructor/step/5/" method="post" id="cForm1">
                        {{ csrf_field() }}
                        <div class="contant-head">Решились на ремонт?
                            Свяжитесь с нами!</div>
                        <div>
                            <input type="text" id="posName" name="name" placeholder="Имя" required>
                        </div>
                        <div>
                            <input type="email" id="posEmail" name="email" placeholder="Email" required>
                        </div>
                        <div>
                            <input type="text" id="posTheme" name="theme" placeholder="Тема">
                        </div>
                        <div>
                            <textarea id="posText" class="message" name="message" placeholder="Сообщение" required></textarea>
                        </div>
                        <div>
                            <button type="button" id="send" class="formStyle submit-button">Отправить</button>
                        </div>
                    </form>
                    <div id="loadBar"></div>
                </div>
                <div class="contact-info">
                    <div class="contant-head">
                        Наши контакты
                    </div>
                    <div class="contact-address">
                        {{ isset($contacts['address']) ? $contacts['address'] : '' }}
                    </div>
                    <div class="contact-phone">
                        {{ isset($contacts['phone']) ? $contacts['phone'] : '' }}
                    </div>
                </div>
                <div class="clearbox"></div>
            </div>
        </div>
    </div>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAM5MKlq4WL9Sidyxdb-pkvuMsD0Pug9PI&sensor=false&extension=.js'></script>
    <script>
        google.maps.event.addDomListener(window, 'load', init);
        var map;
        function init() {
            var mapOptions = {
                center: new google.maps.LatLng({{isset($contacts['latitude']) ? $contacts['latitude'] : ''}}, {{isset($contacts['longitude']) ? $contacts['longitude'] : ''}}),
                zoom: 14,
                zoomControl: false,
                disableDoubleClickZoom: true,
                mapTypeControl: false,
                scaleControl: false,
                scrollwheel: true,
                panControl: false,
                streetViewControl: false,
                draggable : true,
                overviewMapControl: false,
                overviewMapControlOptions: {
                    opened: false,
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#395674"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"color":"#080a0b"},{"visibility":"simplified"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"},{"weight":"0.95"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#415f7f"}]},{"featureType":"landscape","elementType":"labels.text","stylers":[{"hue":"#ff0000"}]},{"featureType":"landscape","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#395674"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"},{"weight":"1"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#456485"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#456485"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#456485"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#c1d4e9"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19},{"visibility":"off"}]},{"featureType":"transit","elementType":"labels.text","stylers":[{"color":"#c1d4e9"},{"visibility":"off"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#9ab3cc"},{"lightness":17}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#395674"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#b9cfe7"}]}],
            }
            var mapElement = document.getElementById('kvadrat');
            var map = new google.maps.Map(mapElement, mapOptions);
            var locations = [
                ['kvadrat', 'undefined', 'undefined', 'undefined', 'undefined', {{isset($contacts['latitude']) ? $contacts['latitude'] : ''}}, {{isset($contacts['longitude']) ? $contacts['longitude'] : ''}}, 'https://mapbuildr.com/assets/img/markers/default.png']
            ];
            for (i = 0; i < locations.length; i++) {
                if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
                if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
                if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
                if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
                if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
                marker = new google.maps.Marker({
                    icon: markericon,
                    position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                    map: map,
                    title: locations[i][0],
                    desc: description,
                    tel: telephone,
                    email: email,
                    web: web
                });
                link = '';     }

        }
    </script>
    <!--
    <style>

    </style> -->
    <div id='kvadrat'></div>
    @include('frontend.fragments.footer')
    <script src="/js/lightbox-plus-jquery.min.js"></script>
    <script>
        $(".fb_1").on({
            "mouseover" : function() {
                this.src = '/images/_0006_icon-fb-hover.png';
            },
            "mouseout" : function() {
                this.src='/images/_0010_icon-fb.png';
            }
        });
        $(".in_1").on({
            "mouseover" : function() {
                this.src = '/images/_0005_icon-inst-hover.png';
            },
            "mouseout" : function() {
                this.src='/images/_0009_icon-inst.png';
            }
        });
        $(".fb_2").on({
            "mouseover" : function() {
                this.src = '/images/_0010_icon-fb.png';
            },
            "mouseout" : function() {
                this.src='/images/_0008_icon-fb-footer.png';
            }
        });
        $(".in_2").on({
            "mouseover" : function() {
                this.src = '/images/_0009_icon-inst.png';
            },
            "mouseout" : function() {
                this.src='/images/_0007_icon-inst-footer.png';
            }
        });
    </script>
    <script src="/js/swiper.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoplay: 10000,
            autoplayDisableOnInteraction: false
        });

        var swiper = new Swiper('.swiper-container2', {
            pagination: '.swiper-pagination2',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationClickable: true,
        });
    </script>
@endsection
