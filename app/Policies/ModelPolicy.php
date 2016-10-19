<?php

namespace App\Policies;

use App\RolePermission;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ModelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Проверка на возможность добалвения сущности
     *
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function add (User $user, Model $model) {
        return $this->checkPermission($user, $model, 'add');
    }


    /**
     * Проверка на возможность просмотра
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function edit (User $user, Model $model) {
        return $this->checkPermission($user, $model, 'edit');
    }

    /**
     * Проверка на возможность просмотра полей сущности
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function view (User $user, Model $model) {
        return $this->checkPermission($user, $model, 'view');
    }

    /**
     * Проверка возможности удаления сущности
     *
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function delete (User $user, Model $model) {
        return $this->checkPermission($user, $model, 'delete');
    }

    /**
     * Проверка на возможность просмотра списка сущностей
     * @param User $user
     * @param Model $model
     * @return bool
     */
    public function index (User $user, Model $model) {
        return $this->checkPermission($user, $model, 'list');
    }


    /**
     * Функция проверки доступности некоторого действия
     *
     * @param User $user
     * @param Model $model
     * @param $action
     * @return bool
     */
    protected function checkPermission (User $user, Model $model, $action) {
        $userRoles = $user->roles->pluck('name_role');
        $modelClassName = get_class($model);

        $rolePermission = RolePermission::whereIn('rp_role_name', $userRoles)->where([
            ['rp_entity_name', $modelClassName],
            ['rp_action', $action]
        ])->first();
        if ($rolePermission) {
            return true;
        }

        return false;
    }
}
