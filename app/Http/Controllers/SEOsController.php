<?php

namespace App\Http\Controllers;

use App\SEO;
use Exception;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SEOsController extends Controller
{
    static $path = '/home/seos/';

    public function __construct() {
        $this->middleware('permission:'.SEO::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SEOs = SEO::where('status', 1)->paginate(20);

        return view('backend.seos.list', [
            'list' => $SEOs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.seos.form', [
            'nameAction' => 'Новое правило SEO',
            'controllerPathList' => self::$path,
            'controllerAction' => 'add',
            'controllerEntity' => new SEO()
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
            'original_url' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.'create/')->withInput()->withErrors($validator);
        }

        try {
            DB::transaction(function () use($request) {
                $SEO = new SEO();
                $SEO->original_url = $request->original_url;
                $SEO->alias_url = $request->alias_url;
                $SEO->title = $request->title;
                $SEO->keywords = $request->keywords;
                $SEO->description = $request->description;
                $SEO->save();
            });
        } catch (Exception $e) {
            return redirect(self::$path.'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Новое правило SEO добавлно!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SEO = SEO::find($id);
        if (!$SEO->status) {
            abort(404);
        }
        return view('backend.seos.view', [
            'item' => $SEO,
            'nameAction' => $SEO->original_url,
            'controllerPathList' => self::$path
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
        $SEO = SEO::find($id);
        if (!$SEO->status) {
            abort(404);
        }

        return view('backend.seos.form', [
            'item' => $SEO,

            'nameAction' => $SEO->original_url,
            'idEntity' => $SEO->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => new SEO(),
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
            'original_url' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.'edit/')->withInput()->withErrors($validator);
        }

        try {
            $SEO = SEO::find($id);
            if (!$SEO->status) {
                abort(404);
            }
            $SEO->original_url = $request->original_url;
            $SEO->alias_url = $request->alias_url;
            $SEO->title = $request->title;
            $SEO->keywords = $request->keywords;
            $SEO->description = $request->description;
            $SEO->save();
        } catch (Exception $e) {
            return redirect(self::$path.$SEO->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect(self::$path.$SEO->id.'/edit/')->with(['success'=>['SEO правило изменено']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SEO = SEO::find($id);
        if (!$SEO->status) {
            abort(404);
        }
        $nameOfDelete = $SEO->original_url;
        $SEO->status = 0;
        $SEO->save();
        return redirect(self::$path)->with(['success'=>[$nameOfDelete.' успешно удалена!']]);
    }
}
