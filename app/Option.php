<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'price', 'status', 'is_dynamic_calculate', 'price_per_meter', 'minimal_dynamic_price'];

    public $timestamps = false;

    /**
     * Рассчитывает стоимость за дополнительную услугу
     *
     * @param null $area Площадь квартиры в метрах квадратных
     * @return float
     */
    public function getPrice($area = null) {
        $price = null;
        if (!is_null($area) && $this->is_dynamic_calculate) {
            $price = $area * $this->price_per_meter;
            if ($price < $this->minimal_dynamic_price) {
                $price = $this->minimal_dynamic_price;
            }
        }

        return !is_null($price) ? $price : $this->price;
    }
}
