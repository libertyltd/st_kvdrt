@extends('layouts.constructor')

@section('content')
    <div id="addressForm" data-hash="{{ csrf_token() }}">
        <h1 class="lg-head helper_text-center">Ваша квартира</h1>
        <div class="form_final_group">
            <input type="text" name="address" placeholder="Адрес квартиры">
            <span class="constructor-hasErrorHint">Необходимо указать адрес</span>
        </div>

        <div class="form_final_group">
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="студия" checked required> Студия
            </label>
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="1"> 1
            </label>
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="2"> 2
            </label>
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="3"> 3
            </label>
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="4"> 4
            </label>
            <label class="constructor_type-apartments">
                <input type="radio" name="apartments_type" value="5"> 5
            </label>
            <input type="text" name="apartments_square" placeholder="Площадь м²" class="constructor_type-apartments-square" maxlength="6" required>
            <span class="constructor-hasErrorHint">Необходимо указать площадь квартиры, для правильного рассчета стоимости</span>
        </div>

        <div class="form_final_group">
            <select name="type_building_id" class="classic" required>
                <option selected value="" disabled>Тип дома</option>
                @foreach($typesBuilding as $typeBuilding)
                    <option value="{{ $typeBuilding->id }}">{{ $typeBuilding->name }}</option>
                @endforeach
            </select>
            <span class="constructor-hasErrorHint">Необходимо указать тип дома</span>
        </div>

        <div class="form_final_group">
            <select name="type_bathroom_id" class="classic" required>
                <option selected value="" disabled>Санузел</option>
                @foreach($typesBathroom as $typeBathroom)
                    <option value="{{ $typeBathroom->id }}">{{ $typeBathroom->name }}</option>
                @endforeach
            </select>
            <span class="constructor-hasErrorHint">Необходимо указать тип санузла</span>
        </div>

        @if($variableParam && $variableParam->count() > 0)
            @foreach ($variableParam as $item)
                @if($item->children->count() > 0)
                    <div class="form_final_group variable_params">
                        <label class="variable_radio">
                            <input type="radio" name="variable_param_radio[{{$item->id}}]" value="{{$item->id}}">
                            <span>{{ $item->name }}</span>
                        </label>
                        @foreach($item->children as $child)
                            <label class="variable_radio">
                                <input type="radio" name="variable_param_radio[{{$item->id}}]" value="{{$child->id}}">
                                <span>
                                        {{ $child->name }}
                                    </span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="form_final_group variable_params">
                        <label class="variable_checkbox" data-toggle="variable_param_checkbox">
                            <input type="checkbox" name="variable_param_checkbox[]" value="{{$item->id}}">
                            <span>
                                    {{ $item->name }}
                                @if(!$item->is_one)
                                    <input type="text" name="variable_param_checkbox_amount[{{$item->id}}]"
                                           placeholder="Количество"
                                           data-min="{{ isset($item->min_amount) ? $item->min_amount : '' }}"
                                           data-max="{{ isset($item->max_amount) ? $item->max_amount : '' }}">
                                @endif
                                </span>
                        </label>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div id="rooms"></div>
    <div id="bathrooms"></div>
    <div id="options">
        <div class="addition_option">
            <div class="addition_option_content">
                <div class="option_block">
                    <div class="option_block_content">
                        <form method="post">
                        </form>
                        <div class="add_diviver"></div>
                        <div class="overall">
                            <div class="overall_cost">
                                <div class="from_a">
                                    Итого
                                </div>
                                <div class="cost-option">
                                    <span id="sum"></span><span> р</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="finalForm">
        <div class="final_form">
            <div class="form_end">
                <div class="lg-head">
                    Приблизительная стоимость ремонта составила
                </div>
                <div class="cost-option" id="full-price">
                    <span id="sumWnd"></span><span> р</span>
                </div>
                <div class="leave_com">
                    оставьте свои контакты, и наш инженер свяжется с вами!
                </div>
                <div class="form_final_group">
                    <input type="email" name="email" placeholder="E-mail" required>
                    <span class="constructor-hasErrorHint">Необходимо указать адрес электронной почты</span>
                </div>
                <div class="form_final_group">
                    <input type="tel" name="phone" placeholder="Телефон" required>
                    <span class="constructor-hasErrorHint">Необходимо указать контактный телефон</span>
                </div>
                <div class="form_final_group">
                    <button>Отправить</button>
                </div>
                <div class="lg-head thanks">
                    Спасибо!
                </div>
                <div class="close_btn">
                    <a href="/" id="final_close"><img src="/images/close_white.png" alt=""></a>
                </div>
            </div>
        </div>
        <div class="clearbox"></div>
    </div>

    <script type="text/javascript" src="/js/constructor.js"></script>
@endsection