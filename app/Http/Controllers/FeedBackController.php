<?php

namespace App\Http\Controllers;

use App\FeedBack;
use App\ImageStorage;
use Exception;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class FeedBackController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.FeedBack::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $FeedBacks = FeedBack::paginate(20);
        foreach ($FeedBacks as &$feedBack) {
            $IM = new ImageStorage($feedBack);
            $feedBack->miniatureSrc = $IM->getCropped('avatar', 50, 50);
        }
        return view('backend.feedbacks.list', ['list' => $FeedBacks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.feedbacks.form', [
            'nameAction' => 'Новый отзыв',
            'controllerPathList' => '/home/feedbacks/',
            'controllerAction' => 'add',
            'controllerEntity' => new FeedBack()
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
            'text' => 'max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/feedbacks/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use ($request) {
                $FeedBack = new FeedBack();
                $FeedBack->name = $request->name;
                $FeedBack->text = $request->text;
                $FeedBack->status = $request->status;
                $FeedBack->save();

                if ($request->avatar) {
                    $IS = new ImageStorage($FeedBack);
                    $IS->save($request->avatar, 'avatar');
                }
            });
        } catch (Exception $e) {
            return redirect('/home/feedbacks/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/feedbacks/')->with(['success'=>['Отзыв клиента добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $FeedBack = FeedBack::find($id);
        $IM = new ImageStorage($FeedBack);
        $FeedBack->miniatureSrc = $IM->getCropped('avatar', 100, 100);
        return view('backend.feedbacks.view', [
            'item' => $FeedBack,
            'nameAction' => $FeedBack->name,
            'controllerPathList' => '/home/feedbacks/'
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
