<?php

namespace App\Http\Controllers;

use App\VariableParam;
use Validator;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class VariableParamController extends Controller
{
    static $path = '/home/variable_parapms/';
    static $pathToView = 'backend.variable_params';

    public function __construct() {
        $this->middleware('permission:'.VariableParam::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $VariableParams = VariableParam::paginate(20);

        return view(self::$pathToView . '.list', [
            'list' => $VariableParams
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $request = request();

        return view(self::$pathToView . '.form', [
            'nameAction' => 'Новый обязательный параметр',
            'controllerPathList' => self::$path,
            'controllerAction' => 'add',
            'controllerEntity' => new VariableParam(),
            'parent_id' => $request->parent,
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
            'min_amount' => 'integer',
            'max_amount' => 'integer',
            'parent_id' => 'integer',
        ]);

        if($validator->fails()) {
            return redirect(self::$path . 'create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->is_one) {
            $request->is_one = 0;
        } else {
            $request->status = 1;
        }

        $request->amount_piece = 0;

        $request->price_per_one = preg_replace('/\s/', '', $request->price_per_one);

        try {
            DB::transaction(function () use($request) {
                $VariableParam = new VariableParam();
                $VariableParam->name = $request->name;
                $VariableParam->amount_piece = $request->amount_piece;
                $VariableParam->price_per_one = $request->price_per_one;
                $VariableParam->min_amount = $request->min_amount;
                $VariableParam->max_amount = $request->max_amount;
                $VariableParam->is_one = $request->is_one;
                if ($request->parent_id) {
                    $VariableParam->parent_id = $request->parent_id;
                }
                $VariableParam->status = $request->status;
                $VariableParam->save();
            });
        } catch (Exception $e) {
            return redirect(self::$pathToView . 'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Обязательный параметр добавлен']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $VariableParam = VariableParam::find($id);
        if (!$VariableParam) {
            abort(404);
        }

        return view(self::$pathToView . '.view', [
            'item' => $VariableParam,
            'nameAction' => $VariableParam->name,
            'controllerPathList' => self::$pathToView
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
        $VariableParam = VariableParam::find($id);
        if (!$VariableParam) {
            abort(404);
        }
        return view(self::$pathToView . '.form', [
            'item' => $VariableParam,

            'nameAction' => $VariableParam->name,
            'idEntity' => $VariableParam->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => new VariableParam(),
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
        $VariableParam = VariableParam::find($id);
        if (!$VariableParam) {
            return redirect(self::$path . $id .'/edit/')->withErrors(['Специального параметра с указанным идентификатором не существует']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'min_amount' => 'integer',
            'max_amount' => 'integer',
            'parent_id' => 'integer',
        ]);

        if($validator->fails()) {
            return redirect(self::$path . $id .'/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->is_one) {
            $request->is_one = 0;
        } else {
            $request->is_one = 1;
        }

        $request->amount_piece = 0;

        $request->price_per_one = preg_replace('/\s/', '', $request->price_per_one);

        try {
            $VariableParam->name = $request->name;
            $VariableParam->amount_piece = $request->amount_piece;
            $VariableParam->price_per_one = $request->price_per_one;
            $VariableParam->min_amount = $request->min_amount;
            $VariableParam->max_amount = $request->max_amount;
            $VariableParam->is_one = $request->is_one;
            $VariableParam->status = $request->status;
            $VariableParam->save();

        } catch (Exception $e) {
            return redirect(self::$path.$VariableParam->id . '/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect(self::$path . $VariableParam->id . '/edit/')->with(['success'=>['Обязательный параметр изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $VariableParam = VariableParam::find($id);
        $nameOfDelete = $VariableParam->name;
        $VariableParam->delete();
        return redirect(self::$path)->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
