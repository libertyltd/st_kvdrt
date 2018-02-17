<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariableParam extends Model {
    protected $table = "variable_params";
    protected $fillable = ['name', 'amount_piece', 'price_per_one', 'min_amount', 'max_amount', 'is_one', 'status'];

    public $timestamps = false;

    public function children() {
        return $this->hasMany('App\VariableParam', 'parent_id', 'id');
    }

    /**
     * Производит подсчет каждого из дополнительных свойств
     * @param $variable_params
     * @param int $apartments_square
     * @return array
     */
    static function getSum ($variable_params, $apartments_square = 0) {
        $additionOptions = [];
        foreach ($variable_params as $item) {
            $VariableParam = VariableParam::find($item['id']);
            if (!$VariableParam) continue;
            if ($VariableParam->is_one) {
                $additionOptions[] = $VariableParam->price_per_one;
            } else {
                $summ = 0;
                if (is_numeric($item['amount'])) {
                    $summ = $VariableParam->price_per_one * $item['amount'];
                } else {
                    $summ = $VariableParam->price_per_one;
                }

                $additionOptions[] = $summ;
            }
            if ($VariableParam->is_square_require) {
                $additionOptions[count($additionOptions) - 1] = $additionOptions[count($additionOptions) - 1] * $apartments_square;
            }
        }
        return $additionOptions;
    }
}