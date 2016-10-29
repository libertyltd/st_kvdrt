<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDesign extends Model
{
    public $fillable = ['name', 'status'];

    public $timestamps = false;

    /**
     * Возвращает дизайн которому принадлежит
     * @return Design
     */
    public function Design () {
        return $this->belongsTo('App\Design');
    }

    /**
     * Возвращает все прикрепленные опции
     * @return DesignOption
     */
    public function DesignOptions () {
        return $this->hasMany('App/DesignOption');
    }
}
