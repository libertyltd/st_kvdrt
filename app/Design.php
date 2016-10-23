<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = ['name', 'lead_description', 'description', 'price', 'status', 'show_in_main'];

    public $timestamps = false;
}
