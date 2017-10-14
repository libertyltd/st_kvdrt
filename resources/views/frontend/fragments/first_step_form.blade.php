<?php
    $variableParam = App\VariableParam::where(['status' => 1, 'parent_id' => null, 'status' => 1])->get();
?>
<div class="final_form">
    <div class="form_end cons_form">
        <form action="/constructor/step/2/" method="post">
            {{ csrf_field() }}
            <div class="lg-head">
                Ваша квартира
            </div>
            <div class="form_final_group">
                <input type="text" name="address" placeholder="Адрес квартиры">
            </div>
            <div class="sq_met">
                <div>
                    <input id="sq_met_stud" class="checkin" type="radio" name="apartments_type" value="студия" checked="checked" required><label for="sq_met_stud" class="studio">Студия</label>
                </div>
                <div>
                    <input id="sq_met_1" class="uncheck" type="radio" name="apartments_type" value="1"><label for="sq_met_1">1</label>
                </div>
                <div>
                    <input id="sq_met_2" class="uncheck" type="radio" name="apartments_type" value="2"><label for="sq_met_2">2</label>
                </div>
                <div>
                    <input id="sq_met_3" class="uncheck" type="radio" name="apartments_type" value="3"><label for="sq_met_3">3</label>
                </div>
                <div>
                    <input id="sq_met_4" class="uncheck" type="radio" name="apartments_type" value="4"><label for="sq_met_4">4</label>
                </div>
                <div>
                    <input id="sq_met_5" class="uncheck" type="radio" name="apartments_type" value="5"><label for="sq_met_5">5</label>
                </div>
                <div>
                    <input id="sq_met_sq" type="text" name="apartments_square" placeholder="Площадь м²"
                    style="
                        display: inline-block;
                        font-size: 16px;
                        font-family: 'SegoeUISemiBold';
                        color: #395674;
                        border-radius: 3px;
                        border: 1px solid #dfdfdf;
                        width: 121px;
                        height: 61px;
                        box-sizing: border-box;
                        padding: 4.8px 4.5px;
                        margin-bottom: 10px;
                    "
                           maxlength="6"
                           required
                    >
                </div>
            </div>
            <div class="form_final_group sl">
                <select name="type_building_id" class="classic" required>
                    <option selected value="" disabled>Тип дома</option>
                    @foreach($typesBuilding as $typeBuilding)
                        <option value="{{ $typeBuilding->id }}">{{ $typeBuilding->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form_final_group sl">
                <select name="type_bathroom_id" class="classic" required>
                    <option selected value="" disabled>Санузел</option>
                    @foreach($typesBathroom as $typeBathroom)
                        <option value="{{ $typeBathroom->id }}">{{ $typeBathroom->name }}</option>
                    @endforeach
                </select>
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
            <div class="form_final_group">
                <button>продолжить</button>
            </div>
        </form>
        <div class="close_btn">
            <button id="final_close"><img src="/images/close_white.png" alt=""></button>
        </div>
    </div>
</div>