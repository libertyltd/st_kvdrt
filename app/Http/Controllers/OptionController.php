<?php

namespace App\Http\Controllers;

use App\Option;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Http\Requests;

class OptionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Option::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Options = Option::paginate(20);
        return view('backend.options.list', [
            'list' => $Options
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.options.form', [
            'nameAction' => 'Новая услуга',
            'controllerPathList' => '/home/options/',
            'controllerAction' => 'add',
            'controllerEntity' => new Option()
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
            'price' => 'required',
            'price_per_meter' => 'required_if:is_dynamic_calculate, 1',
            'minimal_dynamic_price' => 'required_if:is_dynamic_calculate, 1'
        ]);

        if ($validator->fails()) {
            return redirect('/home/options/create/')->withInput()->withErrors($validator);
        }

        if (!$request->is_dynamic_calculate) {
            $request->is_dynamic_calculate = 0;
        } else {
            $request->is_dynamic_calculate = 1;
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $Option = new Option();
                $Option->name = $request->name;
                $Option->price = $request->price;
                $Option->status = $request->status;
                $Option->is_dynamic_calculate = $request->is_dynamic_calculate;
                if ($request->is_dynamic_calculate) {
                    $Option->price_per_meter = $request->price_per_meter;
                    $Option->minimal_dynamic_price = $request->minimal_dynamic_price;
                }
                $Option->save();
            });
        } catch (Exception $e) {
            return redirect('/home/options/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/options/')->with(['success'=>['Дополнительная услуга добавлена!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Option = Option::find($id);
        return view('backend.options.view', [
            'item' => $Option,
            'nameAction' => $Option->name,
            'controllerPathList' => '/home/options/'
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
        $Option = Option::find($id);
        return view('backend.options.form', [
            'item' => $Option,

            'nameAction' => $Option->name,
            'idEntity' => $Option->id,
            'controllerPathList' => '/home/options/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Option(),
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
            'price' => 'required',
            'price_per_meter' => 'required_if:is_dynamic_calculate, 1',
            'minimal_dynamic_price' => 'required_if:is_dynamic_calculate, 1'
        ]);

        if ($validator->fails()) {
            return redirect('/home/options/edit/')->withInput()->withErrors($validator);
        }


        if (!$request->is_dynamic_calculate) {
            $request->is_dynamic_calculate = 0;
        } else {
            $request->is_dynamic_calculate = 1;
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $Option = Option::find($id);
            $Option->name = $request->name;
            $Option->price = $request->price;
            $Option->status = $request->status;
            $Option->is_dynamic_calculate = $request->is_dynamic_calculate;
            if ($request->is_dynamic_calculate) {
                $Option->price_per_meter = $request->price_per_meter;
                $Option->minimal_dynamic_price = $request->minimal_dynamic_price;
            }
            $Option->save();
        } catch (Exception $e) {
            return redirect('/home/options/'.$Option->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/options/'.$Option->id.'/edit/')->with(['success'=>['Дополнительная услуга изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Option = Option::find($id);
        $nameOfDelete = $Option->name;
        $Option->delete();
        return redirect('/home/options/')->with(['success'=>[$nameOfDelete.' успешно удалена!']]);
    }
}
