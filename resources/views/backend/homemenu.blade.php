@section('backendmenu')
    @can('index', new App\Design())
    <li>
        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-arrows" aria-hidden="true"></i>&nbsp;Конструктор&nbsp;<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/home/designs/') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;Дизайны</a></li>
            @can('index', new App\Option())
            <li><a href="{{ url('/home/options/') }}"><i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;Дополнительные услуги (опции)</a></li>
            @endcan
            @can('index', new App\CategoryDesign())
            <li><a href="{{ url('/home/category_designs/') }}"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;Конструктор стиля (категории)</a></li>
            @endcan
            @can('index', new App\DesignOption())
            <li><a href="{{ url('/home/design_options/') }}"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Опции конструктора стиля</a></li>
            @endcan
            @can('index', new App\TypeBuilding())
            <li><a href="{{ url('/home/type_buildings/') }}"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;Типы домов (справочник)</a></li>
            @endcan
            @can ('index', new App\TypeBathroom())
            <li><a href="{{ url('/home/type_bathrooms/') }}"><i class="fa fa-universal-access" aria-hidden="true"></i>&nbsp;Типы санузлов (справочник)</a></li>
            @endcan
        </ul>
    </li>
    @endcan
    @can('index', new App\Order())
    <li><a href="{{ url('/home/orders/') }}"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;Заявки на ремонт</a></li>
    @endcan
    @can('index', new App\Work())
    <li>
        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-files-o" aria-hidden="true"></i>&nbsp;Контент&nbsp;<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            @can('index', new App\Work())
                <li><a href="{{ url('/home/works/') }}"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Выполненные работы</a></li>
                <li><a href="{{ url('/home/work_description/') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Описание раздела выполненных работ</a> </li>
            @endcan
            @can('index', new App\FeedBack())
                <li><a href="{{ url('/home/feedbacks/') }}"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;Отзывы</a></li>
            @endcan
            @can('index', new App\Slider())
                <li><a href="{{ url('/home/sliders/') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;Слайды главной страницы</a></li>
            @endcan
            @can('index', new App\Post())
                <li><a href="{{ url('/home/posts/') }}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Блог</a></li>
            @endcan
            @can('index', new App\PostComment())
                <li><a href="{{ url('/home/post_comments') }}"><i class="fa fa-comments-o" aria-hidden="true"></i> Комментарии к блогу</a></li>
            @endcan
        </ul>
    </li>
    @endcan

    @can('index', new App\SEO())
    <li><a href="{{ url('/home/seos/') }}"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;SEO</a></li>
    @endcan

    @if (Auth::user()->hasRole('Administrator'))
        <li>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cogs" aria-hidden="true"></i> Администрирование <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                @can('index', new App\Contact())
                <li><a href="{{ url('/home/contacts/') }}"><i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp;Контакты</a></li>
                @endcan

                @can('index', new App\User())
                <li><a href="{{ url('/home/users/') }}"><i class="fa fa-users" aria-hidden="true"></i> Пользователи</a></li>
                @endcan

                @can('index', new App\Role())
                <li><a href="{{ url('/home/roles/') }}"><i class="fa fa-user-secret" aria-hidden="true"></i> Роли пользователей</a></li>
                @endcan

                @can('index', new App\RolePermission())
                <li><a href="{{ url('/home/permissions/') }}"><i class="fa fa-user-times" aria-hidden="true"></i> Права доступа</a></li>
                @endcan
            </ul>
        </li>
    @endif
@endsection