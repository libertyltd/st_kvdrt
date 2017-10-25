<?php

namespace App\Http\Controllers;

use App\AdditionalCoefficient;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;

class AdditionalCoefficientController extends Controller
{
    static $path = '/home/additional_coefficients';
    static $pathToView = 'backend.additional_coefficients';

    public function __construct() {
        $this->middleware('permission:'.AdditionalCoefficient::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $additionalCoefficients = AdditionalCoefficient::paginate(20);
        return view(self::$pathToView . '.list', [
            'list' => $additionalCoefficients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(self::$pathToView . '.form', [
            'nameAction' => 'Новый добавочный коэффициент от стоимости',
            'controllerPathList' => self::$path,
            'controllerAction' => 'add',
            'controllerEntity' => new AdditionalCoefficient(),

            'scripts' => [
                '/js/lib/jquery.mask.min.js',
            ]
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
            'percent' => 'integer',
        ]);

        if($validator->fails()) {
            return redirect(self::$path . 'create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use ($request) {
                $ac = new AdditionalCoefficient();
                $ac->name = $request->name;
                $ac->percent = $request->percent;
                $ac->status = $request->status;
                $ac->save();
            });
        } catch (Exception $e) {
            return redirect(self::$pathToView . 'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Добавочный коэффициент от стоимости добавлен']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ac = AdditionalCoefficient::find($id);
        if (!$ac) {
            abort(404);
        }

        return view(self::$pathToView . '.view', [
            'item' => $ac,
            'nameAction' => 'Добавочный коэффициент ' . $ac->percent . '%',
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
        $ac = AdditionalCoefficient::find($id);
        if (!$ac) {
            abort(404);
        }

        return view(self::$pathToView . '.form', [
            'item' => $ac,

            'nameAction' => 'Добавочный коэффициент ' . $ac->percent . '%',
            'idEntity' => $ac->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => new AdditionalCoefficient(),

            'scripts' => [
                '/js/lib/jquery.mask.min.js',
            ]
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
        $ac = AdditionalCoefficient::find($id);
        if (!$ac) {
            return redirect(self::$path . $id .'/edit/')->withErrors(['Добавочного коэффициента с указанным идентификатором не существует']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'percent' => 'integer',
        ]);

        if($validator->fails()) {
            return redirect(self::$path . '/' . $ac->id . '/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $ac->name = $request->name;
            $ac->percent = $request->percent;
            $ac->status = $request->status;
            $ac->save();
        } catch (Exception $e) {
            return redirect(self::$path.  '/' . $ac->id . '/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect(self::$path .  '/' . $ac->id . '/edit/')->with(['success'=>['Добавочный коэффициент изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ac = AdditionalCoefficient::find($id);
        $nameOfDelete = $ac->percent;
        $ac->delete();
        return redirect(self::$path)->with(['success'=>['Добавочный коэффициент ' . $nameOfDelete.'% успешно удален!']]);
    }
}
