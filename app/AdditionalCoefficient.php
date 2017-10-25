<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalCoefficient extends Model
{
    protected $fillable = ['percent', 'name', 'status'];

    public $timestamps = false;
}
