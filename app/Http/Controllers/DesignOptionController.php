<?php

namespace App\Http\Controllers;

use App\Design;
use App\DesignOption;
use App\ImageStorage;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Mockery\CountValidator\Exception;
use Validator;

class DesignOptionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.DesignOption::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $List = DesignOption::paginate(20);
        return view('backend.design_options.list', ['list' => $List]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designs = Design::all();

        return view('backend.design_options.form', [
            'designs' => $designs,

            'nameAction' => 'Новая опция конструктора стиля',
            'controllerPathList' => '/home/design_options/',
            'controllerAction' => 'add',
            'controllerEntity' => new DesignOption()
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
            'category_design_id' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/design_options/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        !isset($request->color) ? $request->color = 'FFFFFF' : '';

        try {
            DB::transaction(function () use ($request) {
                $DesignOption = new DesignOption();
                $DesignOption->color = $request->color;
                $DesignOption->name = $request->name;
                $DesignOption->price = $request->price;
                $DesignOption->category_design_id = $request->category_design_id;
                $DesignOption->status = $request->status;
                $DesignOption->save();

                $IS = null;

                if ($request->hall || $request->bath) {
                    $IS = new ImageStorage($DesignOption);
                }

                if ($request->hall) {
                    $IS->save($request->hall, 'hall');
                }

                if ($request->bath) {
                    $IS->save($request->bath, 'bath');
                }
            });
        } catch (Exception $e) {
            return redirect('/home/design_options/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/design_options/')->with(['success'=>['Опция конструктора стиля добавлена!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $DesignOption = DesignOption::find($id);
        $IM = new ImageStorage($DesignOption);
        $DesignOption->hall = $IM->getCropped('hall', 458, 323);
        $DesignOption->bath = $IM->getCropped('bath', 225, 323);

        return view('backend.designs.view', [
            'item' => $DesignOption,
            'nameAction' => $DesignOption->name,
            'controllerPathList' => '/home/design_options/'
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
        $DesignOption = DesignOption::find($id);

        $IM = new ImageStorage($DesignOption);
        $DesignOption->hall = $IM->getCropped('hall');
        $DesignOption->bath = $IM->getCropped('bath');

        $designs = Design::all();

        return view('backend.design_options.form', [
            'item' => $DesignOption,
            'designs'=> $designs,

            'nameAction' => $DesignOption->name,
            'idEntity' => $DesignOption->id,
            'controllerPathList' => '/home/design_options/',
            'controllerAction' => 'edit',
            'controllerEntity' => new DesignOption(),
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
            'category_design_id' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/home/design_options/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        !isset($request->color) ? $request->color = 'FFFFFF' : '';

        try{

            $DesignOption = DesignOption::find($id);
            $DesignOption->color = $request->color;
            $DesignOption->name = $request->name;
            $DesignOption->price = $request->price;
            $DesignOption->category_design_id = $request->category_design_id;
            $DesignOption->status = $request->status;
            $DesignOption->save();

            $IS = null;

            if ($request->hall || $request->bath) {
                $IS = new ImageStorage($DesignOption);
            }

            if ($request->hall) {
                $IS->save($request->hall, 'hall');
            }

            if ($request->bath) {
                $IS->save($request->bath, 'bath');
            }

        } catch (Exception $e) {
            return redirect('/home/design_options/'.$DesignOption->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/design_options/'.$DesignOption->id.'/edit/')->with(['success'=>['Опция изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $DesignOption = DesignOption::find($id);
        $nameOfDelete = $DesignOption->name;
        $IM = new ImageStorage($DesignOption);
        $IM->deleteNamespaceDir();
        $DesignOption->delete();
        return redirect('/home/design_option/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
