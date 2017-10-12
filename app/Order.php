<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    /**
     * Возвращает все опции дизайна, выбранные пользователем
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function DesignOptions () {
        return $this->belongsToMany('App\DesignOption');
    }

    /**
     * Возвращает все дополнительные опции заказа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Options () {
        return $this->belongsToMany('App\Option');
    }

    /**
     * Возвращает все изменяемые параметры заказа
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function VariableParams() {
        return $this->belongsToMany('App\VariableParam', 'variable_params', 'order_id', 'variable_param_id');
    }

    /**
     * Возвращает тип здания
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TypeBuilding() {
        return $this->belongsTo('App\TypeBuilding');
    }

    /**
     * Возвращет тип санузла
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TypeBathroom() {
        return $this->belongsTo('App\TypeBathroom');
    }

    /**
     * Возвращает дизайн
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Design() {
        return $this->belongsTo('App\Design');
    }

    /**
     * Подсчитывает стоимость заказа
     *
     * @param $apartmentsSquare Площадь квартиры в квадратных метрах
     * @param $priceToMeter Цена за квадратный метр
     * @param $constCY Константа CY
     * @param $additionOption Массив с ценами за дополнительные опции
     * @return mixed
     */
    public static function getFastCalculate ($apartmentsSquare, $priceToMeter, $constCY, $additionOption = [], $addCoefTypeBuilding = 0, $addCoefTypeBathroom = 0) {
        if ($addCoefTypeBuilding == 0) $addCoefTypeBuilding = 1;
        if ($addCoefTypeBathroom == 0) $addCoefTypeBathroom = 1;
        $summ = ($apartmentsSquare-5)*$priceToMeter*$addCoefTypeBuilding+$constCY*$addCoefTypeBathroom;
        foreach ($additionOption as $item) {
            $summ += $item;
        }

        return $summ;
    }
}
