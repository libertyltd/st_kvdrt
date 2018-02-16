<?php

namespace App\Http\Controllers;

use App\TextOnVideo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Exception;

class TextOnVideoController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.TextOnVideo::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = TextOnVideo::first();
        if (!$record) {
            return redirect('/home/textonvideo/create');
        } else {
            return redirect ('/home/textonvideo/' . $record->id . '/edit');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.textonvideo.form', [
            'nameAction' => 'Текст на видео (создание)',
            'controllerPathList' => '/home/textonvideo/',
            'controllerAction' => 'add',
            'controllerEntity' => new TextOnVideo()
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
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/home/textonvideo/create/')->with(['errors' => ['Необходимо указать текст']]);
        }

        try {
            $TextOnVideo = new TextOnVideo();
            $TextOnVideo->text = $request->text;
            $TextOnVideo->save();
        } catch (Exception $e) {
            return redirect('/home/textonvideo/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/textonvideo/' . $TextOnVideo->id . '/edit')->with(['success'=>['Текст успешно изменен']]);
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
        $TextOnVideo = TextOnVideo::first();
        if (!$TextOnVideo) {
            return redirect('/home/textonvideo/create')->with([['errors' => ['Текстовой записи для отображения на видео не добавлено']]]);
        }

        return view('backend.textonvideo.form', [
            'item' => $TextOnVideo,

            'nameAction' => 'Редактирование текста для видео',
            'idEntity' => $TextOnVideo->id,
            'controllerPathList' => '/home/textonvideo/',
            'controllerAction' => 'edit',
            'controllerEntity' => new TextOnVideo(),
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
        $TextOnVideo = TextOnVideo::first();
        if (!$TextOnVideo) {
            return redirect('/home/textonvideo/create')->with([['errors' => ['Текстовая запись для видео не создана']]]);
        }
        try {
            $TextOnVideo->text = $request->text;
            $TextOnVideo->save();
        } catch (Exception $e) {
            return redirect('/home/textonvideo/' . $TextOnVideo->id . '/edit')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/textonvideo/' . $TextOnVideo->id . '/edit')->with(['success' => ['Запись успешно сохранена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
