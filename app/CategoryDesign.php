<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDesign extends Model
{
    public $fillable = ['name', 'price', 'status'];

    public $timestamps = false;
}
