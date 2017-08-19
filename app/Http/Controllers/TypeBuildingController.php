<?php

namespace App\Http\Controllers;

use App\TypeBuilding;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Validator;
use Exception;

class TypeBuildingController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.TypeBuilding::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TypeBuildings = TypeBuilding::paginate(20);
        return view('backend.type_buildings.list', ['list' => $TypeBuildings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.type_buildings.form', [
            'nameAction' => 'Тип здания',
            'controllerPathList' => '/home/type_buildings/',
            'controllerAction' => 'add',
            'controllerEntity' => new TypeBuilding(),
            'scripts' => [
                '/js/lib/jquery.maskMoney.min.js'
            ],
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
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/type_buildings/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $TypeBuilding = new TypeBuilding();
                $TypeBuilding->name = $request->name;
                $TypeBuilding->status = $request->status;
                $TypeBuilding->additional_coefficient = $request->additional_coefficient;
                $TypeBuilding->save();
            });
        } catch (Exception $e) {
            return redirect('/home/type_buildings/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/type_buildings/')->with(['success'=>['Новый тип здания добавлен в справочник']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TypeBuilding = TypeBuilding::find($id);
        return view('backend.type_buildings.view', [
            'item' => $TypeBuilding,
            'nameAction' => $TypeBuilding->name,
            'controllerPathList' => '/home/type_buildings/'
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
        $TypeBuilding = TypeBuilding::find($id);
        return view('backend.type_buildings.form', [
            'item' => $TypeBuilding,

            'nameAction' => $TypeBuilding->name,
            'idEntity' => $TypeBuilding->id,
            'controllerPathList' => '/home/type_buildings/',
            'controllerAction' => 'edit',
            'controllerEntity' => new TypeBuilding(),
            'scripts' => [
                '/js/lib/jquery.maskMoney.min.js'
            ],
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/type_buildings/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $TypeBuilding = TypeBuilding::find($id);
            $TypeBuilding->name = $request->name;
            $TypeBuilding->status = $request->status;
            $TypeBuilding->additional_coefficient = $request->additional_coefficient;
            $TypeBuilding->save();

        } catch (Exception $e) {
            return redirect('/home/type_buildings/'.$TypeBuilding->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/type_buildings/'.$TypeBuilding->id.'/edit/')->with(['success'=>['Тип здания изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TypeBuilding = TypeBuilding::find($id);
        $nameOfDelete = $TypeBuilding->name;
        $TypeBuilding->delete();
        return redirect('/home/type_buildings/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
