<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable = ['name', 'text', 'status'];

    public $timestamps = false;
}
