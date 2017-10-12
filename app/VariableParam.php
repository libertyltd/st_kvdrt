<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariableParam extends Model {
    protected $table = "variable_params";
    protected $fillable = ['name', 'amount_piece', 'price_per_one', 'min_amount', 'max_amount', 'is_one', 'status'];

    public $timestamps = false;

    public function children() {
        return $this->hasMany('App\VariableParam', 'parent_id', 'id');
    }
}