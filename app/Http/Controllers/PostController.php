<?php

namespace App\Http\Controllers;

use App\ImageStorage;
use App\Post;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Validator;

class PostController extends Controller
{
    static $path = '/home/posts/';

    public function __construct() {
        $this->middleware('permission:'.Post::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(20);
        return view('backend.posts.list', [
            'list' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.posts.form', [
            'nameAction' => 'Новый пост',
            'controllerPathList' => '/home/posts/',
            'controllerAction' => 'add',
            'controllerEntity' => new Post(),

            'scripts'=> [
                '/js/lib/moment.js',
                '/js/lib/loc/ru.js',
                '/js/lib/bootstrap-datetimepicker.min.js'
            ],
            'styles' => [
                '/css/bootstrap-datetimepicker.min.css'
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
           'name' => 'string|max:255|required',
           'date_publication' => 'date_format:d-m-Y|required',
           'lead' => 'string|max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.'create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $Post = new Post();
                $Post->name = $request->name;
                $Post->date_publication = date('Y-m-d', strtotime($request->date_publication));
                $Post->lead = $request->lead;
                $Post->description = $request->description;
                $Post->status = $request->status;
                $Post->save();
                if ($request->description_img) {
                    $IM = new ImageStorage($Post);
                    $IM->save($request->description_img, 'description_img');
                }
            });
        } catch (Exception $e) {
            return redirect(self::$path.'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Новый пост добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Post = Post::find($id);
        if (!$Post) {
            return redirect(self::$path)->with(['errors' => ['Пост не найден!']]);
        }

        return view('backend.posts.view', [
            'item' => $Post,
            'nameAction' => $Post->name,
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
        $Post = Post::find($id);
        if (!$Post) {
            return redirect(self::$path)->with(['errors' => ['Пост не найден!']]);
        }

        $IM = new ImageStorage($Post);
        $Post->description_img = $IM->getCropped('description_img');
        $Post->description_img_src = $IM->getOrigImage('description_img');

        return view('backend.posts.form', [
            'item' => $Post,

            'nameAction' => $Post->name,
            'idEntity' => $Post->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => $Post,

            'scripts'=> [
                '/js/lib/moment.js',
                '/js/lib/loc/ru.js',
                '/js/lib/bootstrap-datetimepicker.min.js'
            ],
            'styles' => [
                '/css/bootstrap-datetimepicker.min.css'
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
        $Post = Post::find($id);
        if (!$Post) {
            return redirect(self::$path)->with(['errors' => ['Пост не найден!']]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|required',
            'date_publication' => 'date_format:d-m-Y|required',
            'lead' => 'string|max:255|required',
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.$id.'edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $Post->name = $request->name;
            $Post->date_publication = date('Y-m-d', strtotime($request->date_publication));
            $Post->lead = $request->lead;
            $Post->description = $request->description;
            $Post->status = $request->status;
            $Post->save();
            if ($request->description_img) {
                $IM = new ImageStorage($Post);
                $IM->save($request->description_img, 'description_img');
            }
        } catch (Exception $e) {
            return redirect(self::$path.$Post->id.'/edit/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path.$Post->id.'/edit/')->with(['success'=>['Пост изменен!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Post = Post::find($id);
        if (!$Post) {
            return redirect(self::$path)->with(['errors' => ['Пост не найден!']]);
        }
        $nameOfDelete = $Post->name;
        try {
            $Post->delete();
        } catch (Exception $e) {
            return redirect(self::$path)->with(['errors'=>[$e->getMessage()]]);
        }
        $IM = new ImageStorage($Post);
        $IM->deleteNamespaceDir();
        return redirect(self::$path)->with(['success'=>[$nameOfDelete.' успешно удалена!']]);
    }
}
