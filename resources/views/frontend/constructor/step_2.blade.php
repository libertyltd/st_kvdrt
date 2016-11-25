@extends('layouts.app')

@section('content')
    <div class="page">
        <header>
            <div class="logo">
                <a href="/">
                    <img src="/images/logo.png" alt="Kvadrat.space">
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
                    <a href="#" class="add_cont">Конфигуратор</a>
                </div>
                @if (isset($contacts['facebook_link']) && $contacts['facebook_link'])
                    <div class="socials">
                        <a href="{{ isset($contacts['facebook_link']) ? $contacts['facebook_link'] : '' }}" target="_blank"><img src="/images/_0010_icon-fb.png" class='fb_1' alt="facebook"></a>
                    </div>
                @endif
                @if (isset($contacts['instagram_link']) && $contacts['instagram_link'])
                    <div class="socials">
                        <a href="{{ $contacts['instagram_link'] }}" target="_blank"><img src="/images/_0009_icon-inst.png" class='in_1' alt="instagram"></a>
                    </div>
                @endif
            </div>
        </header>

        <div class="design design-page">
            <div class="lg-head">
                Выберите Дизайн
            </div>
            <div class="reg-content">
                Наши архитекторы создали конструктор сочетающихся между собой элементов, с помощью которого вы можете собрать свой уникальный дизайн или выбрать один из разработанных стилей. Мы особенно внимательно относимся к тактильным свойствам материалов, сочетая последние тенденции в дизайне интерьеров и удобство использования.
            </div>
        </div>
        <div class="design-style white-bg">
            @if (isset($designs))
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
                                    <div class="choose_style">
                                        <a href="/constructor/step/3/{{ $design->id }}/">выбрать</a>
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
                                    <div class="choose_style">
                                        <a href="/constructor/step/3/{{ $design->id }}/">выбрать</a>
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
            @endif

                <footer>
                    <div class="logo">
                        <a href="/">
                            <img src="/images/white-logo.png" alt="">
                            <span>copyright {{$dateYear}}</span>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-email">
                            <a href="mailto:{{isset($contacts['email']) ? $contacts['email'] : '' }}"><img src="/images/_0011_icon-mail.png" alt="" class="icon">{{isset($contacts['email']) ? $contacts['email'] : ''}}</a>
                        </div>
                        <div class="info-phone">
                            <a href="tel:{{isset($contacts['phoneToLink']) ? $contacts['phoneToLink'] : ''}}"><img src="/images/_0012_icon-phone.png" alt="" class="icon">{{isset($contacts['phone']) ? $contacts['phone'] : ''}}</a>
                        </div>
                        <div class="socials">
                            <a href="{{isset($contacts['facebook_link']) ? $contacts['facebook_link'] : ''}}"><img src="/images/_0008_icon-fb-footer.png" class='fb_2' alt="facebook"></a>
                        </div>
                        <div class="socials">
                            <a href="{{isset($contacts['instagram_link']) ? $contacts['instagram_link'] : ''}}"><img src="/images/_0007_icon-inst-footer.png" class='in_2' alt="instagram"></a>
                        </div>
                    </div>
                </footer>
    </div>

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
@endsection