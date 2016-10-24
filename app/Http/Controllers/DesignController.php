<?php

namespace App\Http\Controllers;

use App\Design;
use App\ImageStorage;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Validator;

class DesignController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Design::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Designs = Design::paginate(20);
        foreach ($Designs as &$design) {
            $IM = new ImageStorage($design);
            $design->miniatureSrc = $IM->getCropped('hall', 50, 50);
        }
        return view('backend.designs.list', ['list' => $Designs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.designs.form', [
            'nameAction' => 'Новый дизайн',
            'controllerPathList' => '/home/designs/',
            'controllerAction' => 'add',
            'controllerEntity' => new Design()
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
            'lead_description' => 'required|max:255',
            'price' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/designs/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->show_in_main) {
            $request->show_in_main = 0;
        } else {
            $request->show_in_main = 1;
        }

        try {
            DB::transaction(function () use ($request) {
                $Design = new Design();
                $Design->name = $request->name;
                $Design->lead_description = $request->lead_description;
                $Design->description = $request->description;
                $Design->price = $request->price;
                $Design->status = $request->status;
                $Design->show_in_main = $request->show_in_main;
                $Design->save();

                $IS = null;

                if ($request->hall || $request->bath) {
                    $IS = new ImageStorage($Design);
                }

                if ($request->hall) {
                    $IS->save($request->hall, 'hall');
                }

                if ($request->bath) {
                    $IS->save($request->bath, 'bath');
                }
            });
        } catch (Exception $e) {
            return redirect('/home/designs/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/designs/')->with(['success'=>['Дизайн добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Design = Design::find($id);
        $IM = new ImageStorage($Design);
        $Design->hall = $IM->getCropped('hall', 458, 323);
        $Design->bath = $IM->getCropped('bath', 225, 323);
        return view('backend.designs.view', [
            'item' => $Design,
            'nameAction' => $Design->name,
            'controllerPathList' => '/home/designs/'
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
        $Design = Design::find($id);
        $IM = new ImageStorage($Design);
        $Design->hall = $IM->getCropped('hall');
        $Design->bath = $IM->getCropped('bath');
        return view('backend.designs.form', [
            'item' => $Design,

            'nameAction' => $Design->name,
            'idEntity' => $Design->id,
            'controllerPathList' => '/home/designs/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Design(),
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
            'lead_description' => 'required|max:255',
            'price' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/designs/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->show_in_main) {
            $request->show_in_main = 0;
        } else {
            $request->show_in_main = 1;
        }

        try {
            $Design = Design::find($id);
            $Design->name = $request->name;
            $Design->lead_description = $request->lead_description;
            $Design->description = $request->description;
            $Design->price = $request->price;
            $Design->status = $request->status;
            $Design->show_in_main = $request->show_in_main;
            $Design->save();

            $IS = null;

            if ($request->hall || $request->bath) {
                $IS = new ImageStorage($Design);
            }

            if ($request->hall) {
                $IS->save($request->hall, 'hall');
            }

            if ($request->bath) {
                $IS->save($request->bath, 'bath');
            }

        } catch (Exception $e) {
            return redirect('/home/designs/'.$Design->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/designs/'.$Design->id.'/edit/')->with(['success'=>['Слайд изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Design = Design::find($id);
        $nameOfDelete = $Design->name;
        $IM = new ImageStorage($Design);
        $IM->deleteNamespaceDir();
        $Design->delete();
        return redirect('/home/designs/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
