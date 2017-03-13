<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;
use App\PostComment;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Validator;

class PostCommentController extends Controller
{
    static $path = '/home/post_comments/';

    public function __construct() {
        $this->middleware('permission:'.PostComment::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PostComments = PostComment::where(['post_comment_id'=>null])->orderBy('date_create', 'desc')->paginate(20);

        return view('backend.post_comments.list', [
            'list' => $PostComments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post_comment = null;
        if (isset($_REQUEST['post_comment'])) {
            $post_comment = $_REQUEST['post_comment'];
        }
        $posts = Post::groupBy('date_publication')->get();
        return view('backend.post_comments.form', [
            'nameAction' => 'Новый комментарий',
            'controllerPathList' => self::$path,
            'controllerAction' => 'add',
            'controllerEntity' => new PostComment(),
            'posts'=>$posts,
            'parent_comment'=>$post_comment,

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
            'date_create' => 'date_format:d-m-Y|required',
            'email' => 'email|required',
            'message' => 'string| required'
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.'create/')->withInput()->withErrors($validator);
        }

        try {
            DB::transaction(function () use($request) {
                $PostComment =new PostComment();
                $PostComment->name = $request->name;
                $PostComment->email = $request->email;
                $PostComment->message = $request->message;
                $PostComment->date_create = date('Y-m-d', strtotime($request->date_create));
                $PostComment->post_id = $request->post_id;
                if (isset($request->post_comment_id)) {
                    $PostComment->post_comment_id =$request->post_comment_id;
                }
                $PostComment->save();
            });
        } catch (Exception $e) {
            return redirect(self::$path.'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Комментарий добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $PostComment = PostComment::find($id);
        if (!$PostComment) {
            return redirect(self::$path)->with(['errors' => ['Комментарий не найден!']]);
        }

        return view('backend.post_comments.view', [
            'item' => $PostComment,
            'nameAction' => $PostComment->name,
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
        $PostComment = PostComment::find($id);
        if (!$PostComment) {
            return redirect(self::$path)->with(['errors' => ['Комментарий не найден!']]);
        }
        $posts = Post::groupBy('date_publication')->get();

        return view('backend.post_comments.form', [

            'item' => $PostComment,

            'nameAction' => $PostComment->name,
            'idEntity' => $PostComment->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => $PostComment,
            'posts'=>$posts,

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
        $PostComment = PostComment::find($id);
        if (!$PostComment) {
            return redirect(self::$path)->with(['errors' => ['Комментарий не найден!']]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|required',
            'date_create' => 'date_format:d-m-Y|required',
            'email' => 'email|required',
            'message' => 'string| required'
        ]);

        if ($validator->fails()) {
            return redirect(self::$path.$id.'edit/')->withInput()->withErrors($validator);
        }

        try {
            $PostComment->name = $request->name;
            $PostComment->email = $request->email;
            $PostComment->message = $request->message;
            $PostComment->date_create = date('Y-m-d', strtotime($request->date_create));
            $PostComment->post_id = $request->post_id;
            $PostComment->save();
        } catch (Exception $e) {
            return redirect(self::$path.$id.'/edit/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path.$id.'/edit/')->with(['success'=>['Ответ изменен!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $PostComment = PostComment::find($id);
        if (!$PostComment) {
            return redirect(self::$path)->with(['errors' => ['Комментарий не найден!']]);
        }
        $nameOfDelete = date('d.m.Y', strtotime($PostComment->date_create)).'-'.$PostComment->name;
        try {
            $PostComment->delete();
        } catch (Exception $e) {
            return redirect(self::$path)->with(['errors'=>[$e->getMessage()]]);
        }
        return redirect(self::$path)->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
