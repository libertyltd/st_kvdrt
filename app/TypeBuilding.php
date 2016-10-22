<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeBuilding extends Model
{
    protected $fillable = ['name', 'status'];

    public $timestamps = false;
}
