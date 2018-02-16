<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextOnVideo extends Model
{
    public $timestamps = false;
    protected $fillable = ['text'];
}
