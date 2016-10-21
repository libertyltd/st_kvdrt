@extends('layouts.app')

@section('content')
    <div class="page">
        <header>
            <div class="logo">
                <a href="/">
                    <img src="/images/logo.png" alt="">
                </a>
            </div>
            <div class="info">
                <div class="info-email">
                    <a href="mailto:{{ isset($contacts['email']) ? $contacts['email'] : '' }}"><img src="/images/_0011_icon-mail.png" alt="" class="icon">{{ isset($contacts['email']) ? $contacts['email'] : '' }}</a>
                </div>
                <div class="info-phone">
                    <a href="tel:{{ isset($contacts['phoneToLink']) ? $contacts['phoneToLink'] : '' }}"><img src="/images/_0012_icon-phone.png" alt="" class="icon">{{ isset($contacts['phone']) ? $contacts['phone'] : '' }}</a>
                </div>
                <div class="conf-btn">
                    <a href="/constructor/step1">Конфигуратор</a>
                </div>
                @if (isset($contacts['facebook_link']) && $contacts['facebook_link'])
                <div class="socials">
                    <a href="{{ $contacts['facebook_link'] }}" target="_blank"><img src="/images/_0010_icon-fb.png" class='fb_1' alt="facebook"></a>
                </div>
                @endif
                @if (isset($contacts['instagram_link']) && $contacts['instagram_link'])
                <div class="socials">
                    <a href="{{ $contacts['instagram_link'] }}" target="_blank"><img src="/images/_0009_icon-inst.png" class='in_1' alt="instagram"></a>
                </div>
                @endif
            </div>
        </header>
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
                                <a href="{{ isset($slide->button_link) ? $slide->button_link : '#' }}">{{ $slide->button_text }}</a>
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
                    <li><a href="#tab2">Этапы работы<img src="/images/_0013_arrow-left.png" alt=""></a></li>
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
                            <a href="design.html" class='add_cont'>Рассчитать</a>
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
        <div class="design">
            <div class="lg-head">
                Дизайн
            </div>
            <div class="reg-content">
                Всерьез задумали изменить интерьер? Мы поможем определиться с новыми цветами, текстурами и аксессуарами. Соберите собственный дизайн с помощью конструктора или выберите уже готовый вариант. Ваша идея - наша реализация!
            </div>
        </div>
        <div class="design-style">
            <!-- @TODO:доделать -->
        </div>

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
                    <!--
                    <div class="swiper-slide">
                        <div class="feedback-img">
                            <img src="images/circle1.png" alt="">
                        </div>
                        <div class="feedback-response">
                            Ничего не понимаю в ремонте, поэтому обратилась к ребятам и ни разу не пожалела.
                            Видно, что люди, которые работают в KVADRAT.Space, точно на своем месте.
                            <a href="">Светлана Мизюкина</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="feedback-img">
                            <img src="images/circle2.png" alt="">
                        </div>
                        <div class="feedback-response">
                            Хотите быстрый, красивый и качественный ремонт и при этом заплатить меньше денег? Вам нужно в KVADRAT.Space! Я все сказала! :)
                            <a href="">Ольга Макарова</a>
                        </div>
                    </div>
                    -->
                </div>
                @if($feedbacks->count() > 1)
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                @endif
                <!-- Add Pagination -->
                <div class="swiper-pagination2"></div>
            </div>
        </div>
    </div>
@endsection
