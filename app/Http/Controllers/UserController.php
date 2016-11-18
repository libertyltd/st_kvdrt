<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Mail\Message;
use Illuminate\Support\MessageBag;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->cannot('index', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $users = User::paginate(20);
        return view('backend.users.list', ['list'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->cannot('add', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $roles = Role::all();

        return view('backend.users.form', ['nameAction' => 'Создание нового пользователя',
            'roles' => $roles,
            'controllerPathList' => '/home/users/',
            'controllerAction' => 'add',
            'controllerEntity' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->cannot('add', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'max:255',
            'middlename' => 'max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|confirmed|max:255',
            'roles' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect('/home/users/create/')->withInput()->withErrors($validator);
        }

        if (isset($request->send_mail)) {
            $request->send_mail = 1;
        } else {
            $request->send_mail = 0;
        }

        /**
         * Создаем пользователя
         */
        try {
            DB::transaction(function () use ($request) {
                $user = new User();
                $user->name = $request->name;
                $user->surname = $request->surname;
                $user->middlename = $request->middlename;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->send_mail = $request->send_mail;
                $user->save();

                /**
                 * Проверяем роли пользователя и выставляем их в БД
                 */
                $user->roles()->sync($request->input('roles', []));
                return true;
            });
        } catch (Exception $e) {
            $message = new MessageBag([$e->getMessage()]);
            return redirect('/home/users/create/')->with($message);
        }

        return redirect('/home/users/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->cannot('view', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $user = User::find($id);
        $userData = $user->surname.' '.$user->name.' '.$user->middlename;

        return view('backend.users.view', [
            'nameAction' => $userData,
            'email' => $user->email,
            'roles' => $user->roles,
            'controllerPathList' => '/home/users/'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->cannot('edit', new User())) {
            abort(403, 'Доступ запрещен');
        }

        /* Получили пользователя */
        $user = User::find($id);

        if (!$user) {
            abort(404, 'Запрашиваемый пользователь не найден');
        }

        /* Получили список всех ролей пользователя */
        $userRoles = $user->roles;
        $rolesAll = Role::all();

        foreach ($rolesAll as &$role) {

            foreach ($userRoles as $roleUser) {

                if ($role->name_role === $roleUser->name_role) {
                    $role->active = 'active';
                    $role->checked = 'checked';
                }
            }

        }

        return view('backend.users.form', ['nameAction' => $user->surname.' '.$user->name.' '.$user->middlename,
            'surname' => $user->surname,
            'name' => $user->name,
            'middlename' => $user->middlename,
            'email' => $user->email,
            'roles' => $rolesAll,
            'item' => $user,
            'idEntity' => $user->id,
            'controllerPathList' => '/home/users/',
            'controllerAction' => 'edit',
            'controllerEntity' => new User()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->cannot('edit', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $success = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'max:255',
            'middlename' => 'max:255',
            'roles' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect('/home/users/'.$id.'/edit/')->withInput()->withErrors($validator);
        }

        if (isset($request->send_mail)) {
            $request->send_mail = 1;
        } else {
            $request->send_mail = 0;
        }



        try {
            DB::transaction(function () use ($request, $id, &$success) {
                $user = User::find($id);
                $user->name = $request->name;
                $user->surname = $request->surname;
                $user->middlename = $request->middlename;
                $user->send_mail = $request->send_mail;

                if ($user->email !== $request->email && $request->email !== '') {
                    $user = User::find(['email'=>$request->email]);
                    if ($user) {
                        //Выкидываем сообщение об ошибке
                        $message = new MessageBag(['email уже используется ситемой']);
                        return redirect('/home/users/'.$id.'/edit/')->with($message);
                    } else {
                        $user->email = $request->email;
                        $success[] = 'E-mail адрес успешно изменен';
                    }

                }

                if ($user->password != '' && $request->password === $request->password_confirmation) {
                    $user->password = Hash::make($request->password);
                    $success[] = 'Пароль успешно изменен';
                }


                $user->save();
                /**
                 * Проверяем роли пользователя и выставляем их в БД
                 */
                $user->roles()->sync($request->input('roles', []));
                return true;
            });
        } catch (Exception $e) {
            $message = new MessageBag([$e->getMessage()]);
            return redirect('/home/users/'.$id.'/edit/')->with($message);
        }

        return redirect('/home/users/'.$id.'/edit/')->with(['success' => $success]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->cannot('delete', new User())) {
            abort(403, 'Доступ запрещен');
        }

        $user = User::find($id);
        if (!$user) {
            abort(404, 'Пользователя с таким id не существует');
        }

        $userData = $user->surname.' '.$user->name.' '.$user->middlename;

        $user->delete();

        return redirect('/home/users/')->with(['success'=>[
            'Пользователь '.$userData.' успешно удален.'
        ]]);
    }
}
