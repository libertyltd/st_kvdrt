<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'date_publication', 'lead', 'description', 'status'];

    public function postComments () {
        return $this->hasMany('App\PostComment');
    }

    /**
     * Возвращает человекопонятное представление времени
     * @return string
     */
    public function getHumanDatePublication () {
        $months = [
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря'
        ];

        $currentMonth = date('m', strtotime($this->date_publication));
        $currentDate = date('d', strtotime($this->date_publication));
        $currentYear = date('Y', strtotime($this->date_publication));
        return $currentDate.' '.$months[$currentMonth-1].' '.$currentYear;
    }
}
