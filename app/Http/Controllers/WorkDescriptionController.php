<?php

namespace App\Http\Controllers;

use App\WorkDescription;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Exception;
use DB;

class WorkDescriptionController extends Controller
{
    protected $path = '/home/work_description/';
    public function __construct() {
        $this->middleware('permission:'.WorkDescription::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $WorkDescription = WorkDescription::first();
        return view ('backend.work_description.list', [
            'item'=>$WorkDescription
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Проверим наличие элементов в базе перед открытиыем формы добавления
        $WorkDescription = WorkDescription::first();

        if ($WorkDescription) {
            return redirect($this->path)->with(['errors' => ['Описание раздело может быть только в одном экземпляре!']]);
        }

        return view('backend.work_description.form', [
            'nameAction' => 'Описание раздела "Выполненные работы"',
            'controllerPathList' => $this->path,
            'controllerAction' => 'add',
            'controllerEntity' => new WorkDescription()
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
        //Проверим наличие элементов в базе перед инициализацией проверки
        $WorkDescription = WorkDescription::first();

        if ($WorkDescription) {
            return redirect($this->path)->with(['errors' => ['Описание раздело может быть только в одном экземпляре!']]);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($this->path.'create/')->withInput()->withErrors($validator);
        }

        try {
            DB::transaction(function () use($request) {
                $WorkDescription = new WorkDescription();
                $WorkDescription->description = $request->description;
                $WorkDescription->save();
            });
        } catch (Exception $e) {
            return redirect($this->path.'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect($this->path)->with(['success'=>['Описание раздела "Выполненные работы" добавлено!']]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $WorkDescription = WorkDescription::find($id);
        return view('backend.work_description.view', [
            'item' => $WorkDescription,
            'nameAction' => $WorkDescription->id,
            'controllerPathList' => $this->description
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
        $WorkDescription = WorkDescription::find($id);
        if (!$WorkDescription) {
            abort(404);
        }

        return view('backend.work_description.form', [
            'item' => $WorkDescription,
            'nameAction' => 'Редактирование описания',
            'idEntity' => $WorkDescription->id,
            'controllerPathList' => $this->path,
            'controllerAction' => 'edit',
            'controllerEntity' => $WorkDescription,
        ]);
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
        $WorkDescription = WorkDescription::find($id);
        if (!$WorkDescription) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($this->path.$WorkDescription->id.'/edit/')->withInput()->withErrors($validator);
        }

        try {
            $WorkDescription->description = $request->description;
            $WorkDescription->save();
        } catch (Exception $e) {
            return redirect($this->path.$WorkDescription->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect($this->path.$WorkDescription->id.'/edit/')->with(['success'=>['Описание успешно измененено!']]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $WorkDescription = WorkDescription::find($id);
        if (!$WorkDescription) {
            abort(404);
        }
        $WorkDescription->delete();
        return redirect($this->path)->with(['success'=>['Описание успешно удалено']]);
    }
}
