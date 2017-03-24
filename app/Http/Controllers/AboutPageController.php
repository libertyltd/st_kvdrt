<?php

namespace App\Http\Controllers;

use App\AboutPage;
use App\ImageStorage;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class AboutPageController extends Controller
{
    static $path = '/home/about_page/';

    public function __construct() {
        $this->middleware('permission:'.AboutPage::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AboutPage = AboutPage::paginate(20);
        return view('backend.about_page.list', [
            'list'=>$AboutPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Добавим защиту от создания нескольких экземпляров страницы о компании
        $AboutPage = AboutPage::all();
        if ($AboutPage->count() > 0) {
            return redirect(self::$path)->with(['errors' => ['Одновременно может быть создан только один экземпляр страницы "О компании"']]);
        }

        return view('backend.about_page.form', [
            'nameAction' => 'Создание страницы "О компании"',
            'controllerPathList' => '/home/about_page/',
            'controllerAction' => 'add',
            'controllerEntity' => new AboutPage(),
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
        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $AboutPage = new AboutPage();
                $AboutPage->description = $request->description;
                $AboutPage->status = $request->status;
                $AboutPage->save();
                if ($request->description_img) {
                    $IM = new ImageStorage($AboutPage);
                    $IM->save($request->description_img, 'description_img');
                }
            });
        } catch (Exception $e) {
            return redirect(self::$path.'create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path)->with(['success'=>['Страница "О компании" добавлена']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $AboutPage = AboutPage::find($id);
        if ($AboutPage) {
            return redirect(self::$path)->widt(['errors' => ['Данные страницы "О компании" не найдены']]);
        }

        return view('backend.about_page.view', [
            'item' => $AboutPage,
            'nameAction' => 'О компании',
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
        $AboutPage = AboutPage::find($id);
        if (!$AboutPage) {
            return redirect(self::$path)->widt(['errors' => ['Данные страницы "О компании" не найдены']]);
        }

        $IM = new ImageStorage($AboutPage);
        $AboutPage->description_img = $IM->getCropped('description_img');
        $AboutPage->description_img_src = $IM->getOrigImage('description_img');

        return view('backend.about_page.form', [
            'item' => $AboutPage,

            'nameAction' => 'Редактирование данные страницы "О компании"',
            'idEntity' => $AboutPage->id,
            'controllerPathList' => self::$path,
            'controllerAction' => 'edit',
            'controllerEntity' => $AboutPage,
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
        $AboutPage = AboutPage::find($id);
        if (!$AboutPage) {
            return redirect(self::$path)->with(['errors' => ['Данные страницы "О компании" не найдены']]);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            $AboutPage->description = $request->description;
            $AboutPage->status = $request->status;
            $AboutPage->save();
            if ($request->description_img) {
                $IM = new ImageStorage($AboutPage);
                $IM->save($request->description_img, 'description_img');
            }
        } catch (Exception $e) {
            return redirect(self::$path.$AboutPage->id.'/edit/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect(self::$path.$AboutPage->id.'/edit/')->with(['success'=>['Данные страницы "О компании" успешно сохранены!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AboutPage = AboutPage::find($id);
        if (!$AboutPage) {
            return redirect(self::$path)->with(['errors' => ['Данные страницы "О компании" не найдены']]);
        }
        try {
            $AboutPage->delete();
        } catch (Exception $e) {
            return redirect(self::$path)->with(['errors'=>[$e->getMessage()]]);
        }
        $IM = new ImageStorage($AboutPage);
        $IM->deleteNamespaceDir();
        return redirect(self::$path)->with(['success'=>['Данные страницы "О компании" успешно удалены!']]);
    }
}
