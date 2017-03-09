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