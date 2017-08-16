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

        <div class="addition_option">
            <div class="addition_option_content">
                <div class="lg-head">
                    Дополнительные опции <sub>Шаг 3 из 3</sub>
                </div>
                <div class="option_block">
                    <div class="option_block_content">
                        <form action="/constructor/step/5/" method="post" id="additionOption">
                            {{ csrf_field() }}
                            @foreach($options as $option)
                            <div class="option-item">
                                <div class="option-name">{{$option->name}}</div>
                                <div class="option-radio">
                                    <div class="cost-option" id="win_ch">
                                        <span>{{ \App\Design::formatPrice($option->getPrice($apartments_square ? $apartments_square : null)) }}</span><span> р</span>
                                    </div>
                                    <div>
                                        <input id="option{{$option->id}}on" class="checkin" type="radio" name="option{{$option->id}}" value="{{$option->id}}"><label data-price="{{$option->price}}" for="option{{$option->id}}on">Да</label>
                                    </div>
                                    <div>
                                        <input id="option{{$option->id}}off" class="uncheck" type="radio" name="option{{$option->id}}"><label for="option{{$option->id}}off">Нет</label>
                                    </div>
                                </div>
                                <div class="clearbox"></div>
                            </div>
                            @endforeach
                        </form>
                        <div class="add_diviver"></div>
                        <div class="overall">
                            <div class="overall_cost">
                                <div class="from_a">
                                    Итого
                                </div>
                                <div class="cost-option">
                                    <span id="sum" data-sum="{{$summ}}">{{ \App\Design::formatPrice($summ) }}</span><span> р</span>
                                </div>
                            </div>
                            <div class="contin">
                                <button href="" class="cont_btn add_cont">Продолжить</button>
                            </div>
                        </div>
                        <div class="final_form">
                            <div class="form_end">
                                    <div class="lg-head">
                                        Приблизительная стоимость ремонта составила
                                    </div>
                                    <div class="cost-option" id="full-price">
                                        <span id="sumWnd">{{ \App\Design::formatPrice($summ) }}</span><span> р</span>
                                    </div>
                                    <div class="leave_com">
                                        оставьте свои контакты, и наш инженер свяжется с вами!
                                    </div>
                                    <div class="form_final_group">
                                        <input form="additionOption" type="email" name="email" placeholder="E-mail" required>
                                    </div>
                                    <div class="form_final_group">
                                        <input form="additionOption" type="tel" name="phone" placeholder="Телефон" required>
                                    </div>
                                    <div class="form_final_group">
                                        <button form="additionOption">Отправить</button>
                                    </div>
                                    <div class="lg-head thanks">
                                        Спасибо!
                                    </div>
                                <div class="close_btn">
                                    <button id="final_close"><img src="/images/close_white.png" alt=""></button>
                                </div>
                            </div>
                        </div>
                        <div class="clearbox"></div>
                    </div>
                </div>
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