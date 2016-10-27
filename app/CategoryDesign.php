<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDesign extends Model
{
    public $fillable = ['name', 'status'];

    public $timestamps = false;

    public function Design () {
        return $this->belongsTo('App\Design');
    }
}
