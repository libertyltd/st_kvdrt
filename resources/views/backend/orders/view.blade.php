@extends('layouts.backend')

@section('title')
    {{ $nameAction }}
@endsection

@include('backend.homemenu')

@section('content')
    <div class="container-fluid">
        <h1>{{ $nameAction }}</h1>
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <label class="col-sm-3">Имя клиента:</label>
                    <div class="col-sm-9">
                        {{ $item->name }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Email клиента:</label>
                    <div class="col-sm-9">
                        {{ $item->email }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Тема обращения:</label>
                    <div class="col-sm-9">
                        {{ $item->theme }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Сообщение:</label>
                    <div class="col-sm-9">
                        {{ $item->message }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Адрес:</label>
                    <div class="col-sm-9">
                        {{ $item->address }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Тип квартиры (студтия, 1, 2 и т.д. комнат):</label>
                    <div class="col-sm-9">
                        {{ $item->apartments_type }}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3">Площадь квартиры в м<sup>2</sup>:</label>
                    <div class="col-sm-9">
                        {{ $item->apartments_square }}
                    </div>
                </div>

                @if($item->type_building_id)
                <div class="row">
                    <label class="col-sm-3">Тип здания:</label>
                    <div class="col-sm-9">
                        {{ $item->TypeBuilding->name }}
                    </div>
                </div>
                @endif

                @if($item->type_bathroom_id)
                <div class="row">
                    <label class="col-sm-3">Тип санузла:</label>
                    <div class="col-sm-9">
                        {{ $item->TypeBathroom->name }}
                    </div>
                </div>
                @endif

                @if($item->design_id)
                <div class="row">
                    <label class="col-sm-3">Дизайн:</label>
                    <div class="col-sm-9">
                        {{ $item->Design->name }}
                    </div>
                </div>
                @endif

                @if($item->DesignOptions)
                <div class="row">
                    <label class="col-sm-3">Выбранные опции дизайна:</label>
                    <div class="col-sm-9">
                        <ul>
                        @foreach($item->DesignOptions as $option)
                            <li>{{ $option->CategoryDesign->name }} -> {{ $option->name }} ({{ \App\Design::formatPrice($option->price) }} руб.)</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if($item->Options)
                <div class="row">
                    <label class="col-sm-3">Дополнительные опции заказа:</label>
                    <div class="col-sm-9">
                        <ul>
                            @foreach($item->Options as $option)
                                <li>{{ $option->name }} ({{\App\Design::formatPrice($option->price)}} руб.)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="row">
                    <label class="col-sm-3">Текущий статус заявки:</label>
                    <div class="col-sm-9">
                        @if($item->status == 0)
                            Новая заявка
                        @elseif($item->status == 1)
                            Заявка в работе
                        @else
                            Заявка завершена
                        @endif
                    </div>
                </div>



                <a href="{{ isset($controllerPathList) ? $controllerPathList : url('/home/') }}" class="btn btn-default">Назад</a>
            </div>
        </div>
    </div>
@endsection