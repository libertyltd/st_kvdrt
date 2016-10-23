<?php

namespace App\Http\Controllers;

use App\Design;
use App\ImageStorage;
use Illuminate\Http\Request;

use App\Http\Requests;

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
            'lead_design' => 'required|max:255',
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

            });
        } catch (Exception $e) {

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
