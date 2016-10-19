<?php

namespace App\Http\Controllers;

use App\Role;
use App\RolePermission;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use League\Flysystem\Exception;
use Symfony\Component\Routing\Annotation\Route;

class RolePermissionController extends Controller
{
    /**
     * Показывает доступные сущности и права на них
     */
    public function index() {
        if (Auth::user()->cannot('index', new RolePermission())) {
            abort(403, 'Доступ запрещен');
        }
        $rolePermissions = RolePermission::paginate(20);
        return view('backend.permissions.list', ['list'=>$rolePermissions]);
    }

    /**
     * Добавляем новое правило
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request) {
        if (Auth::user()->cannot('add', new RolePermission())) {
            abort(403, 'Доступ запрещен');
        }
        if ($request->method() === 'GET') {
            /* Составим списки всех доступных ролей, и доступных действий */
            $roles = Role::all();

            $actions = [
                [
                    'name' => 'add',
                    'description' => 'Добавление',
                    'select' => ''
                ],
                [
                    'name' => 'edit',
                    'description' => 'Редактирование',
                    'select' => ''
                ],
                [
                    'name' => 'view',
                    'description' => 'Просмотр',
                    'select' => ''
                ],
                [
                    'name' => 'delete',
                    'description' => 'Удаление',
                    'select' => ''
                ],
                [
                    'name' => 'list',
                    'description' => 'Просмотр списка',
                    'select' => ''
                ]
            ];
            return view('backend.permissions.form', ['nameAction' => 'Новое правило доступа', 'roles' => $roles, 'actions' => $actions,
                'controllerAction' => 'add',
                'controllerPathList' => '/home/permissions/',
                'controllerEntity' => new RolePermission(),
                'controllerEntityDelete' => ''
            ]);
        }

        if ($request->method() === 'POST') {

            $validator = Validator::make($request->all(), [
                'rp_role_name' => 'required|max:255',
                'rp_entity_name' => 'required|max:255',
                'rp_action' => 'required|in:add,edit,view,delete,list'
            ]);

            if ($validator->fails()) {
                return redirect('/home/permissions/add/')->withInput()->withErrors($validator);
            }

            /* Проверяем нет ли для выбранных параметров совпадений */
            $existingRolePermission = RolePermission::where([
                'rp_role_name' => $request->rp_role_name,
                'rp_entity_name' => $request->rp_entity_name,
                'rp_action' => $request->rp_action
            ])->get()->first();

            if ($existingRolePermission) {
                $message = new MessageBag(['Правило с выставленными параметрами уже существует']);
                return redirect('/home/permissions/add/')->withInput()->withErrors($message);
            }

            try{
                $Entity = new $request->rp_entity_name();
            } catch (Exception $e) {
                $message = new MessageBag(['Указанная сущность не существует в системе']);
                return redirect('/home/permissions/add/')->withInput()->withErrors($message);
            }

            try {
                $RolePermission = new RolePermission();
                $RolePermission->rp_role_name = $request->rp_role_name;
                $RolePermission->rp_entity_name = $request->rp_entity_name;
                $RolePermission->rp_action = $request->rp_action;
                $RolePermission->save();
            } catch (Exception $e) {
                $message = new MessageBag([$e->getMessage()]);
                return redirect('/home/permissions/add/')->withInput()->withErrors($message);
            }


            return redirect('/home/permissions/');
        }
    }

    /**
     * Редактируем существующее правило
     *
     * @param Request $request
     * @param null $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null) {
        if ($request->method() === 'GET') {

            if (Auth::user()->cannot('edit', new RolePermission()) || Auth::user()->cannot('view', new RolePermission())) {
                abort(403, 'Доступ запрещен');
            }

            $editableRolePermission = RolePermission::where('rp_id', $id)->get()->first();

            if (!$editableRolePermission) {
                return view('backend.common.error.404');
            }

            $roles = Role::all();

            foreach ($roles as $role) {
                if ($role->name_role === $editableRolePermission->rp_role_name) {
                    $role->select = 'selected';
                }
            }

            $actions = [
                [
                    'name' => 'add',
                    'description' => 'Добавление',
                    'select' => ''
                ],
                [
                    'name' => 'edit',
                    'description' => 'Редактирование',
                    'select' => ''
                ],
                [
                    'name' => 'view',
                    'description' => 'Просмотр',
                    'select' => ''
                ],
                [
                    'name' => 'delete',
                    'description' => 'Удаление',
                    'select' => ''
                ],
                [
                    'name' => 'list',
                    'description' => 'Просмотр списка',
                    'select' => ''
                ]
            ];

            foreach ($actions as &$action) {
                if ($editableRolePermission->rp_action === $action['name']) {
                    $action['select'] = 'selected';
                }
            }

            $rp_entity_name = $editableRolePermission->rp_entity_name;

            return view('backend.permissions.form', [
                'nameAction' => 'Правило доступа для роли '.$editableRolePermission->rp_role_name.' к сущности '.$editableRolePermission->rp_entity_name,
                'roles' => $roles,
                'actions' => $actions,
                'rp_entity_name' => $editableRolePermission->rp_entity_name,
                'controllerAction' => 'edit',
                'controllerPathList' => '/home/permissions/',
                'controllerEntity' => new RolePermission(),
                'controllerEntityDelete' => '/home/permissions/'.$editableRolePermission->rp_id.'/delete/'
            ]);

        }

        if ($request->method() === 'POST') {
            if (Auth::user()->cannot('edit', new RolePermission())) {
                abort(403, 'Доступ запрещен');
            }
            $validator = Validator::make($request->all(), [
                'rp_role_name' => 'required|max:255',
                'rp_entity_name' => 'required|max:255',
                'rp_action' => 'required|in:add,edit,view,delete,list'
            ]);

            if ($validator->fails()) {
                return redirect('/home/permissions/'.$id.'/edit/')->withInput()->withErrors($validator);
            }

            /* Проверяем нет ли для выбранных параметров совпадений */
            $existingRolePermission = RolePermission::where([
                'rp_role_name' => $request->rp_role_name,
                'rp_entity_name' => $request->rp_entity_name,
                'rp_action' => $request->rp_action
            ])->get()->first();

            if ($existingRolePermission) {
                $message = new MessageBag(['Правило с выставленными параметрами уже существует']);
                return redirect('/home/permissions/'.$id.'/edit/')->withInput()->withErrors($message);
            }

            try{
                $Entity = new $request->rp_entity_name();
            } catch (Exception $e) {
                $message = new MessageBag(['Указанная сущность не существует в системе']);
                return redirect('/home/permissions/'.$id.'/edit/')->withInput()->withErrors($message);
            }

            try {
                $RolePermission = RolePermission::where('rp_id', $id)->get()->first();;
                $RolePermission->rp_role_name = $request->rp_role_name;
                $RolePermission->rp_entity_name = $request->rp_entity_name;
                $RolePermission->rp_action = $request->rp_action;
                $RolePermission->save();
            } catch (Exception $e) {
                $message = new MessageBag([$e->getMessage()]);
                return redirect('/home/permissions/'.$id.'/edit/')->withInput()->withErrors($message);
            }


            return redirect('/home/permissions/')->with(['success'=>[
                'Правило успешно сохранено'
            ]]);
        }
    }

    /**
     * Удаляем существующее правило
     *
     * @param Request $request
     * @param null $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete (Request $request, $id = null) {
        if (Auth::user()->cannot('delete', new RolePermission())) {
            abort(403, 'Доступ запрещен');
        }
        if (is_null($id)) {
            $message = new MessageBag(['Не передан параметр определяющий конкретное правило']);
            return redirect('/home/permissions/')->withErrors($message);
        }

        $deletedRolePermission = RolePermission::find($id);
        if (!$deletedRolePermission) {
            $message = new MessageBag(['Не существует правила с переданным параметром']);
            return redirect('/home/permissions/')->withErrors($message);
        }

        $deletedRolePermission->delete();

        return redirect('/home/permissions/')->with(['success'=>[
            'Правило успешно удалено'
        ]]);
    }
}
