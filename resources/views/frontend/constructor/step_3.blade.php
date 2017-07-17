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
        <div class="constructor">
            <div class="constructor_content">
                <div class="constructor_img">
                    <div class="constructor_head">
                        <div class="lg-head design-head">
                            Конструктор стиля <sub>Шаг 2 из 3</sub>
                        </div>
                        <div class="const_cost">
                            <div class="from_a">
                                Итого
                            </div>
                            <div class="cost-option">
                                <span id="sum" data-sum="{{$summ}}">{{ \App\Design::formatPrice($summ) }}</span><span> р</span>
                            </div>
                        </div>
                        <div class="clearbox"></div>
                    </div>
                    <div class="constructor_images">
                        <div class="">
                            <div class="left_img">
                                <img src="{{$design->hall[0]}}" alt="">
                            </div>
                            <div class="right_img">
                                <img src="{{$design->bath[0]}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- @TODO: Вставить сюда кнопку и варинты выбора -->
                <div class="constructor_style">
                    <button type="submit" form="optionsForm" class="cont_btn" >Продолжить</button>
                    <div class="constructor_work style-1">
                        <form id="optionsForm" action="/constructor/step/4/" method="post">
                            {{ csrf_field() }}
                            @foreach($categoryAndOptions as $item)
                                <div class="cons_item">
                                    <button type="button" class="btn_cons" data-toggle="collapse" data-target="#category{{$item['idCategory']}}">{{$item['nameCategory']}}</button>
                                    <div id="category{{$item['idCategory']}}" class="collapse">
                                        <div class="const-radio">
                                            @foreach($item['options'] as $option)
                                            <div>
                                                <input id="category_{{$item['idCategory']}}_{{$option['id']}}" class="checkin" type="radio" name="category{{$item['idCategory']}}" value="{{$option['id']}}">
                                                <label for="category_{{$item['idCategory']}}_{{$option['id']}}"
                                                data-hall = "{{$option['hall']}}" data-bath = "{{$option['bath']}}" data-price="{{$option['price']}}"
                                                >
                                                    <div class="square" style="background-color:#{{$option['color']}}"></div>
                                                    <div class="color_struct">{{$option['name']}}</div>
                                                    <div class="cost-option"><span>{{ \App\Design::formatPrice($option['price']) }}</span><span> р</span></div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                        <div class="force-overflow"></div>
                    </div>
                </div>
                <div class="clearbox"></div>
            </div>
        </div>

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