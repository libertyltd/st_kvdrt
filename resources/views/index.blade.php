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
        <div class="hero">
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <div class="swiper-slide slide1">
                        <div class="slide-content">
                            <div class="hero-head">
                                Ремонт за фиксированное время по фиксированной цене
                            </div>
                            <div class="conf-btn">
                                <a href="constructor.html">Конфигуратор</a>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="swiper-slide slide2">
                        <div class="slide-content">
                            <div class="hero-head">
                                Ремонт за фиксированное время по фиксированной цене
                            </div>
                            <div class="conf-btn">
                                <a href="constructor.html">Конфигуратор</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide slide3">
                        <div class="slide-content">
                            <div class="hero-head">
                                Ремонт за фиксированное время по фиксированной цене
                            </div>
                            <div class="conf-btn">
                                <a href="constructor.html">Конфигуратор</a>
                            </div>
                        </div>
                    </div>
                    -->

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
@endsection
