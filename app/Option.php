<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'price', 'status'];

    public $timestamps = false;
}
