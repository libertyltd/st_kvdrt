<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignOption extends Model
{

    protected $fillable = ['color', 'name', 'price', 'status'];

    public $timestamps = false;

    public function CategoryDesign () {
        return $this->belongsTo('App\CategoryDesign', 'category_design_id');
    }
}
