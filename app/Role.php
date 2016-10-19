<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property string $name_role
 * @method static \Illuminate\Database\Query\Builder|\App\Role whereNameRole($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    protected $table = 'role';
    public $incrementing = false;
    public $primaryKey = 'name_role';

    protected $fillable = ['name_role'];

    public $timestamps = false;
}
