@extends('layouts.app')
@section('content')
    @include('frontend.fragments.first_step_form')
    @include('frontend.fragments.header')
    <div class="container">
        <div class="blog__header">
            <img class="blog__header__cover" src="/img/mockup.jpg">
            <div class="blog__header__title">
                <h1 class="blog__title">Заголовок</h1>
                <div class="blog__time-publication">1 января 2016</div>
                <p class="blog__lead">kdjflsdkjf sdlfj lsdjf sdhf osdhf sdfh sodufhdsfhdskjfhks dskfh sdifuh sdfn isduhf idjfn dsuhf idufn iudf iduhf iduhf iduhf iduhf idsuhf iduhf idufhidfuhidsajdfnlakdjflad lkasjhf klajdhf lakjhfk lajdhf lakjdhf ldajhf lajdkhf</p>
            </div>
        </div>
        <div class="blog__content">
            <p>Контент</p>
        </div>
        <div class="blog__social">
            <script type="text/javascript">(function() {
                    if (window.pluso)if (typeof window.pluso.start == "function") return;
                    if (window.ifpluso==undefined) { window.ifpluso = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                        s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                        var h=d[g]('body')[0];
                        h.appendChild(s);
                    }})();</script>
            <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email"></div>
        </div>
    </div>
    <div class="blog__comment-form">
        <div class="container">
            <form class="blog__comment-form__input-place" method="post">
                <h3 class="blog__comment-form__title">Оставить комментарий:</h3>
                <input class="blog__comment-form__control" name="name" type="text" placeholder="Имя">
                <input class="blog__comment-form__control" name="email" type="email" placeholder="Email">
                <div class="blog__comment-form__capcha">
                    <img class="blog__comment-form__capcha__img" src="/img/code.png">
                    <input class="blog__comment-form__capcha__input" name="capcha" type="text" placeholder="Код">
                </div>
                <textarea name="message" class="blog__comment-form__message" rows="10" placeholder="Сообщение"></textarea>
                <div class="blog__comment-form__submit">
                    <button class="btn btn-info" type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </div>
    <div class="comment__list">
        <div class="container">
            <div class="comment__item">
                <div class="comment__item__name">Андрей</div>
                <div class="comment__item__date">17.09.216</div>
                <div class="comment__item__message">
                    djldskfj lskjf sdkfj owefo eifj;dkfjsl;j lsdufhi dsfhklja lkfjhdaifuh iadsuhf ladkjfn kadsjfnlkdasjhfl udf iudsahf jdashflk jadshfo iudahf jadnf.dmnf,mndbsfkljdh lfjdashf lkjdashflkdjhfk ldjhfkl
                </div>
            </div>
            <div class="comment__item comment__item_answer">
                <div class="comment__item__name">Андрей</div>
                <div class="comment__item__date">17.09.216</div>
                <div class="comment__item__message">
                    djldskfj lskjf sdkfj owefo eifj;dkfjsl;j lsdufhi dsfhklja lkfjhdaifuh iadsuhf ladkjfn kadsjfnlkdasjhfl udf iudsahf jdashflk jadshfo iudahf jadnf.dmnf,mndbsfkljdh lfjdashf lkjdashflkdjhfk ldjhfkl
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h3 class="last-news__title">Последние новости:</h3>
        <div class="blog_list">
            <div class="blog_list-item__zero"></div>
            <div class="blog_list-item">
                <img class="blog_list-item__cover" src="/img/mockup.jpg">
                <div class="blog_list-item__description">
                    <a href="#" class="blog_list-item__title">Большая и длинная тема поста</a>
                    <div class="blog_list-item__time_publication">21 сентября 2016</div>
                    <div class="blog_list-item__lead">
                        ;asdkjslkdl nsodijf odsjfh kdshuf kdsjfh kdsjfh kdsjfhl sieufh wpoeifj dslknjx,mbn d;o q[ewokfn a;dcvjna duhgo lkmadclvnck bru ihcnkcjbv iuewhfi jnv,mcbvj egfi weufn skbvj kfvhui rsufnvfkjbvfkmbjjk
                    </div>
                    <div class="blog_list-item__btn">
                        <a class="btn btn-default" href="#" rel="nofollow">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="blog_list-item">
                <img class="blog_list-item__cover" src="/img/mockup.jpg">
                <div class="blog_list-item__description">
                    <a href="#" class="blog_list-item__title">Большая и длинная тема поста</a>
                    <div class="blog_list-item__time_publication">21 сентября 2016</div>
                    <div class="blog_list-item__lead">
                        ;asdkjslkdl nsodijf odsjfh kdshuf kdsjfh kdsjfh kdsjfhl sieufh wpoeifj dslknjx,mbn d;o q[ewokfn a;dcvjna duhgo lkmadclvnck bru ihcnkcjbv iuewhfi jnv,mcbvj egfi weufn skbvj kfvhui rsufnvfkjbvfkmbjjk
                    </div>
                    <div class="blog_list-item__btn">
                        <a class="btn btn-default" href="#" rel="nofollow">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="blog_list-item last">
                <img class="blog_list-item__cover" src="/img/mockup.jpg">
                <div class="blog_list-item__description">
                    <a href="#" class="blog_list-item__title">Большая и длинная тема поста</a>
                    <div class="blog_list-item__time_publication">21 сентября 2016</div>
                    <div class="blog_list-item__lead">
                        ;asdkjslkdl nsodijf hkjfhdskfj skdjfh ksdjfh ksdjfh kdsjfh kdsfh kdsjfh kdsjfh kdsjfh dsiufysodufyidsufh ksdjfnk sdkfh odsfh ksdjfn kdsfuhy isdufhy isdjfh isduyf isdufh kdsjfh sidufy siduh odsjfh kdshuf kdsjfh kdsjfh kdsjfhl sieufh wpoeifj dslknjx,mbn d;o q[ewokfn a;dcvjna duhgo lkmadclvnck bru ihcnkcjbv iuewhfi jnv,mcbvj egfi weufn skbvj kfvhui rsufnvfkjbvfkmbjjk
                    </div>
                    <div class="blog_list-item__btn">
                        <a class="btn btn-default" href="#" rel="nofollow">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.fragments.footer')
@endsection