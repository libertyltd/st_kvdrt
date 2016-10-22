<?php

namespace App\Http\Controllers;

use App\ImageStorage;
use App\Work;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Validator;
use Exception;



class WorkController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Work::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Works = Work::paginate(20);
        foreach ($Works as &$work) {
            $IM = new ImageStorage($work);
            $work->miniatureSrc = $IM->getCropped('image', 50, 50);
        }
        return view('backend.works.list', ['list' => $Works]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.works.form', [
            'nameAction' => 'Новая работа',
            'controllerPathList' => '/home/works/',
            'controllerAction' => 'add',
            'controllerEntity' => new Work()
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
            'square' => 'max:10',
        ]);

        if ($validator->fails()) {
            return redirect('/home/works/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $Work = new Work();
                $Work->name = $request->name;
                $Work->square = $request->square;
                $Work->description = $request->description;
                $Work->status = $request->status;
                $Work->save();

                if ($request->image) {
                    $IS = new ImageStorage($Work);
                    $IS->save($request->image, 'image');
                }
            });
        } catch (Exception $e) {
            return redirect('/home/works/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/works/')->with(['success'=>['Слайдер добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Work = Work::find($id);
        $IM = new ImageStorage($Work);
        $Work->miniatureSrc = $IM->getCropped('image', 100, 50);
        return view('backend.works.view', [
            'item' => $Work,
            'nameAction' => $Work->name,
            'controllerPathList' => '/home/works/'
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
        $Work = Work::find($id);
        $IM = new ImageStorage($Work);
        $Work->image = $IM->getCropped('image', 300, 300);
        return view('backend.works.form', [
            'item' => $Work,

            'nameAction' => $Work->name,
            'idEntity' => $Work->id,
            'controllerPathList' => '/home/works/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Work(),
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
            'square' => 'max:10',
        ]);

        if ($validator->fails()) {
            return redirect('/home/works/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $Work = Work::find($id);
            $Work->name = $request->name;
            $Work->square = $request->square;
            $Work->description = $request->description;
            $Work->status = $request->status;
            $Work->save();

            if ($request->image) {
                $IS = new ImageStorage($Work);
                $IS->save($request->image, 'image');
            }
        } catch (Exception $e) {
            return redirect('/home/works/'.$Work->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/works/'.$Work->id.'/edit/')->with(['success'=>['Работа изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = Work::find($id);
        $nameOfDelete = $work->name;
        $IM = new ImageStorage($work);
        $IM->deleteNamespaceDir();
        $work->delete();
        return redirect('/home/works/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
