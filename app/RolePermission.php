<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RolePermission
 *
 * @property integer $rp_id
 * @property string $rp_role_name
 * @property string $rp_entity_name
 * @property string $rp_action
 * @method static \Illuminate\Database\Query\Builder|\App\RolePermission whereRpId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RolePermission whereRpRoleName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RolePermission whereRpEntityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RolePermission whereRpAction($value)
 * @mixin \Eloquent
 */
class RolePermission extends Model
{
    protected $table = 'role_permission';
    public $primaryKey = 'rp_id';
    public $timestamps = false;

    protected $fillable=['rp_role_name', 'rp_entity_name', 'rp_action'];
}
