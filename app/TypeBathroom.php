<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeBathroom extends Model
{
    protected $fillable = ['name', 'status'];

    public $timestamps = false;
}
