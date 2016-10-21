<?php

namespace App\Http\Controllers;

use App\ImageStorage;
use App\Slider;
use Intervention\Image\Image;
use Validator;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Slider::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sliders = Slider::paginate(20);
        foreach ($Sliders as &$slider) {
            $IM = new ImageStorage($slider);
            $slider->miniatureSrc = $IM->getCropped('image', 50, 50);
        }
        return view('backend.sliders.list', ['list' => $Sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sliders.form', [
            'nameAction' => 'Новый слайд',
            'controllerPathList' => '/home/sliders/',
            'controllerAction' => 'add',
            'controllerEntity' => new Slider()
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
            'promo_text' => 'max:255',
            'button_text' => 'max:20',
            'button_link' => 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/home/sliders/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->show_button) {
            $request->show_button = 0;
        } else {
            $request->show_button = 1;
        }

        try {
            DB::transaction(function () use($request) {
                $Slider = new Slider();
                $Slider->promo_text = $request->promo_text;
                $Slider->show_button = $request->show_button;
                $Slider->button_text = $request->button_text;
                $Slider->button_link = $request->button_link;
                $Slider->status = $request->status;
                $Slider->save();

                if ($request->image) {
                    $IS = new ImageStorage($Slider);
                    $IS->save($request->image, 'image');
                }
            });
        } catch (Exception $e) {
                return redirect('/home/sliders/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/sliders/')->with(['success'=>['Слайдер добавлен!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Slider = Slider::find($id);
        $IM = new ImageStorage($Slider);
        $Slider->miniatureSrc = $IM->getCropped('image', 100, 50);
        return view('backend.sliders.view', [
            'item' => $Slider,
            'nameAction' => str_limit($Slider->promo_text, 20),
            'controllerPathList' => '/home/sliders/'
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
        $Slider = Slider::find($id);
        $IM = new ImageStorage($Slider);
        $Slider->image = $IM->getCropped('image', 300, 300);
        return view('backend.sliders.form', [
            'item' => $Slider,

            'nameAction' => str_limit($Slider->promo_text, 20),
            'idEntity' => $Slider->id,
            'controllerPathList' => '/home/sliders/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Slider(),
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
            'promo_text' => 'max:255',
            'button_text' => 'max:20',
            'button_link' => 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/home/sliders/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if (!$request->show_button) {
            $request->show_button = 0;
        } else {
            $request->show_button = 1;
        }

        try {
            $Slider = Slider::find($id);
            $Slider->promo_text = $request->promo_text;
            $Slider->show_button = $request->show_button;
            $Slider->button_text = $request->button_text;
            $Slider->button_link = $request->button_link;
            $Slider->status = $request->status;
            $Slider->save();

            if ($request->image) {
                $IS = new ImageStorage($Slider);
                $IS->save($request->image, 'image');
            }
        } catch (Exception $e) {
            return redirect('/home/sliders/'.$Slider->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/sliders/'.$Slider->id.'/edit/')->with(['success'=>['Контактная запись изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $nameOfDelete = str_limit($slider->promo_text, 20);
        $IM = new ImageStorage($slider);
        $IM->deleteNamespaceDir();
        $slider->delete();
        return redirect('/home/sliders/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
