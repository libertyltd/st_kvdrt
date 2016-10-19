<?php

namespace App\Http\Controllers;

use App\Role;
use DB;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\MessageBag;
use Validator;

class RolesController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Role::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(20);
        return view('backend.roles.list', ['list'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.roles.form', [
            'nameAction' => 'Создание новой роли',
            'controllerPathList' => '/home/users/',
            'controllerAction' => 'add',
            'controllerEntity' => new Role()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_role' => 'required|unique:role,name_role|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/roles/create/')->withInput()->withErrors($validator);
        }

        /**
         * Создаем новую роль
         */
        try {
            DB::transaction(function () use ($request) {
                $role = new Role();
                $role->name_role = $request->name_role;
                $role->save();
                return true;
            });
        } catch (Exception $e) {
            $message = new MessageBag([$e->getMessage()]);
            return redirect('/home/roles/create/')->with($message);
        }

        return redirect('/home/roles/');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name_role
     * @return \Illuminate\Http\Response
     */
    public function show($name_role)
    {
        $role = Role::find($name_role);

        return view('backend.roles.view', [
            'nameAction' => $role->name_role,
            'name_role' => $role->name_role,
            'controllerPathList' => '/home/roles/'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name_role
     * @return \Illuminate\Http\Response
     */
    public function edit($name_role)
    {
        $role = Role::find($name_role);

        return view('backend.roles.form', [
            'nameAction' => $role->name_role,
            'name_role' => $role->name_role,
            'idEntity' => $role->name_role,
            'controllerPathList' => '/home/roles/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Role()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $name_role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name_role)
    {
        $validator = Validator::make($request->all(), [
            'name_role' => 'required|unique:role,name_role|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/roles/'.$name_role.'/edit')->withInput()->withErrors($validator);
        }

        $role = Role::find($name_role);
        $role->name_role = $request->name_role;
        $role->save();

        return redirect('/home/roles/'.$role->name_role.'/edit/')->with(['success'=>['Роль успешно изменена.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $name_role
     * @return \Illuminate\Http\Response
     */
    public function destroy($name_role)
    {
        $role = Role::find($name_role);
        $nameOfRole = $role->name_role;
        $role->delete();
        return redirect('/home/roles/')->with(['success'=>['Роль '.$nameOfRole.' успешно удалена!']]);
    }
}
