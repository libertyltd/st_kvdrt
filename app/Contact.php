<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['email', 'phone', 'facebook_link', 'instagram_link', 'address', 'status'];


    public $timestamps = false;
}
