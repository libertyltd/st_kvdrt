@section('backendmenu')
    @can('index', new App\Work())
    <li><a href="{{ url('/home/works/') }}"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Выполненные работы</a></li>
    @endcan
    @can('index', new App\FeedBack())
    <li><a href="{{ url('/home/feedbacks/') }}"><i class="fa fa-rss" aria-hidden="true"></i>&nbsp;Отзывы</a></li>
    @endcan
    @can('index', new App\Slider())
    <li><a href="{{ url('/home/sliders/') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;Слайды главной страницы</a></li>
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