<?php

namespace App\Http\Controllers;

use App\CategoryDesign;
use App\Design;
use Exception;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryDesignController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.CategoryDesign::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CD = CategoryDesign::paginate(20);
        return view('backend.category_designs.list', [
            'list' => $CD
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designs = Design::all();
        return view('backend.category_designs.form', [
            'designs' => $designs,

            'nameAction' => 'Новая категория',
            'controllerPathList' => '/home/category_designs/',
            'controllerAction' => 'add',
            'controllerEntity' => new CategoryDesign()
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
            'design_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/category_designs/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $CategoryDesign = new CategoryDesign();
                $CategoryDesign->name = $request->name;
                $CategoryDesign->design_id = $request->design_id;
                $CategoryDesign->status = $request->status;
                $CategoryDesign->save();

            });
        } catch (Exception $e) {
            return redirect('/home/category_designs/create/')->with(['errors' => [$e->getMessage()]]);
        }

        $design = Design::find($request->design_id);
        return redirect('/home/category_designs/')->with(['success'=>['Новая категория для дизайна '.$design->name.'!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CategoryDesign = CategoryDesign::find($id);

        return view('backend.category_designs.view', [
            'item' => $CategoryDesign,
            'nameAction' => $CategoryDesign->name,
            'controllerPathList' => '/home/category_designs/'
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
        $CategoryDesign = CategoryDesign::find($id);
        $selectedDesign = $CategoryDesign->Design->id;


        $Designs = Design::all();
        foreach ($Designs as &$design) {
            if ($design->id == $selectedDesign) {
                $design->selected = 'selected';
            }
        }

        return view('backend.category_designs.form', [
            'item' => $CategoryDesign,
            'designs' => $Designs,

            'nameAction' => $CategoryDesign->name,
            'idEntity' => $CategoryDesign->id,
            'controllerPathList' => '/home/category_designs/',
            'controllerAction' => 'edit',
            'controllerEntity' => new CategoryDesign(),
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
            'design_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/category_designs/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $categoryDesigns = CategoryDesign::find($id);
            $categoryDesigns->name = $request->name;
            $categoryDesigns->design_id = $request->design_id;
            $categoryDesigns->status = $request->status;
            $categoryDesigns->save();

        } catch (Exception $e) {
            return redirect('/home/category_designs/'.$categoryDesigns->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/category_designs/'.$categoryDesigns->id.'/edit/')->with(['success'=>['Категория изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryDesigns = CategoryDesign::find($id);
        $nameOfDelete = $categoryDesigns->name;
        $categoryDesigns->delete();
        return redirect('/home/category_designs/')->with(['success'=>[$nameOfDelete.' успешно удалена!']]);
    }
}
