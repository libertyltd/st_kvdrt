<?php

namespace App\Http\Controllers;

use App\TypeBathroom;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Validator;

class TypeBathroomController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.TypeBathroom::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TypeBathroom = TypeBathroom::paginate(20);
        return view('backend.type_bathrooms.list', ['list' => $TypeBathroom]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.type_bathrooms.form', [
            'nameAction' => 'Тип санузла',
            'controllerPathList' => '/home/type_bathrooms/',
            'controllerAction' => 'add',
            'controllerEntity' => new TypeBathroom(),
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
            return redirect('/home/type_bathrooms/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $TypeBathroom = new TypeBathroom();
                $TypeBathroom->name = $request->name;
                $TypeBathroom->status = $request->status;
                $TypeBathroom->additional_coefficient = $request->additional_coefficient;
                $TypeBathroom->save();
            });
        } catch (Exception $e) {
            return redirect('/home/type_bathrooms/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/type_bathrooms/')->with(['success'=>['Новый тип санузла добавлен в справочник']]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TypeBathroom = TypeBathroom::find($id);
        return view('backend.type_bathrooms.view', [
            'item' => $TypeBathroom,
            'nameAction' => $TypeBathroom->name,
            'controllerPathList' => '/home/type_bathrooms/'
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
        $TypeBathroom = TypeBathroom::find($id);
        return view('backend.type_bathrooms.form', [
            'item' => $TypeBathroom,

            'nameAction' => $TypeBathroom->name,
            'idEntity' => $TypeBathroom->id,
            'controllerPathList' => '/home/type_bathrooms/',
            'controllerAction' => 'edit',
            'controllerEntity' => new $TypeBathroom(),
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
            return redirect('/home/type_bathrooms/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $TypeBathroom = TypeBathroom::find($id);
            $TypeBathroom->name = $request->name;
            $TypeBathroom->status = $request->status;
            $TypeBathroom->additional_coefficient = $request->additional_coefficient;
            $TypeBathroom->save();

        } catch (Exception $e) {
            return redirect('/home/type_bathrooms/'.$TypeBathroom->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/type_bathrooms/'.$TypeBathroom->id.'/edit/')->with(['success'=>['Тип санузла изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TypeBathroom = TypeBathroom::find($id);
        $nameOfDelete = $TypeBathroom->name;
        $TypeBathroom->delete();
        return redirect('/home/type_bathrooms/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
