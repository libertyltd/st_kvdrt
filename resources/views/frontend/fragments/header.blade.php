<header class="{{isset($class) ? $class : ''}}">
    <div class="logo">
        <a href="/">
            <img src="/images/logo.png" alt="">
        </a>
    </div>
    <ul class="header_menu">
        <li class="header_menu_item"><a class="{{ isset($blogActive) ? 'active' : '' }}" href="/blog/">Блог</a></li>
        <?php
            $AboutPage = App\AboutPage::where(['status'=>1])->first();
            $showAbout = false;
            if ($AboutPage) {
                $showAbout = true;
            }
            $SEO = App\SEO::where(['original_url'=>'about', 'status'=>1])->first();
            $AboutPageUrl = '/about/';
            if ($SEO && $SEO->alias_url) {
                $AboutPageUrl = '/'.$SEO->alias_url;
            }
        ?>
        @if($showAbout)
            <li class="header_menu_item"><a class="{{ isset($aboutActive) ? 'active' : '' }}" href="{!!$AboutPageUrl!!}">О компании</a></li>
        @endif
        <li class="header_menu_item"><a href="#design" data-toggle="slowScroll">Дизайны</a></li>
        <li class="header_menu_item"><a href="#partners" data-toggle="slowScroll">Партнеры</a></li>
        <li class="header_menu_item"><a href="#contacts" data-toggle="slowScroll">Контакты</a></li>
    </ul>
    <div class="info">
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