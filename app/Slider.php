<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['promo_text', 'show_button', 'button_text', 'button_link', 'status'];

    public $timestamps = false;
}
