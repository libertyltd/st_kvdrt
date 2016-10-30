<?php

namespace App\Http\Controllers;

use App\Design;
use App\Option;
use App\Order;
use App\TypeBathroom;
use App\TypeBuilding;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Validator;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Order::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Orders = Order::paginate(20);
        $Orders->groupBy('status', 'desc');

        return view('backend.orders.list', [
            'list' => $Orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Designs = Design::all();
        $Options = Option::all();
        $TypesBuilding = TypeBuilding::all();
        $TypesBathroom = TypeBathroom::all();

        return view('backend.orders.form', [
            'designs' => $Designs,
            'options' => $Options,
            'typesBuilding' => $TypesBuilding,
            'typesBathroom' => $TypesBathroom,


            'nameAction' => 'Новая заявка',
            'controllerPathList' => '/home/orders/',
            'controllerAction' => 'add',
            'controllerEntity' => new Order()
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
            'name' => 'max:255',
            'email' => 'email|required|max:255',
            'theme' => 'max:255',
            'address' => 'max:255',
            'apartments_type' => 'max:255',
            'apartments_square' => 'numeric',
            'phone' => 'max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/orders/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        }

        if (!$request->type_building_id) {
            $request->type_building_id = NULL;
        }

        if (!$request->type_bathroom_id) {
            $request->type_bathroom_id = NULL;
        }

        if (!$request->design_id) {
            $request->design_id = NULL;
        }

        try {
            DB::transaction(function () use($request) {
                $Order = new Order();
                $Order->name = $request->name;
                $Order->email = $request->email;
                $Order->theme = $request->theme;
                $Order->message = $request->message;
                $Order->address = $request->address;
                $Order->apartments_type = $request->apartments_type;
                $Order->apartments_square = $request->apartments_square;
                $Order->type_building_id = $request->type_building_id;
                $Order->type_bathroom_id = $request->type_bathroom_id;
                $Order->design_id = $request->design_id;
                $Order->phone = $request->phone;
                $Order->status = $request->status;
                $Order->save();

                if ($request->design_option_id) {
                    $Order->DesignOptions()->sync($request->design_option_id);
                } else {
                    $Order->DesignOptions()->sync([]);
                }

                if ($request->option_id) {
                    $Order->Options()->sync($request->option_id);
                } else {
                    $Order->Options()->sync([]);
                }
            });
        } catch (Exception $e) {
            return redirect('/home/orders/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/orders/')->with(['success'=>['Дополнительная услуга добавлена!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Order = Order::find($id);

        return view('backend.orders.view', [
            'item' => $Order,
            'nameAction' => $Order->email,
            'controllerPathList' => '/home/orders/'
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
        $Order = Order::find($id);
        $Designs = Design::all();
        $Options = Option::all();
        $TypesBuilding = TypeBuilding::all();
        $TypesBathroom = TypeBathroom::all();

        foreach ($Options as &$option) {
            foreach ($Order->Options as $orderOption) {
                if ($option->id == $orderOption->id) {
                    $option->active = 'active';
                }
            }
        }

        foreach ($TypesBuilding as &$building) {
            if ($building->id == $Order->type_building_id) {
                $building->selected = 'selected';
            }
        }

        foreach ($TypesBathroom as &$bathroom) {
            if ($bathroom->id == $Order->type_bathroom_id) {
                $bathroom->selected = 'selected';
            }
        }

        return view('backend.orders.form', [
            'item' => $Order,
            'designs' => $Designs,
            'options' => $Options,
            'typesBuilding' => $TypesBuilding,
            'typesBathroom' => $TypesBathroom,

            'nameAction' => $Order->name,
            'idEntity' => $Order->id,
            'controllerPathList' => '/home/orders/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Order(),
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
            'name' => 'max:255',
            'email' => 'email|required|max:255',
            'theme' => 'max:255',
            'address' => 'max:255',
            'apartments_type' => 'max:255',
            'apartments_square' => 'numeric',
            'phone' => 'max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/home/orders/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        }

        if (!$request->type_building_id) {
            $request->type_building_id = NULL;
        }

        if (!$request->type_bathroom_id) {
            $request->type_bathroom_id = NULL;
        }

        if (!$request->design_id) {
            $request->design_id = NULL;
        }

        try {
            $Order = Order::find($id);
            $Order->name = $request->name;
            $Order->email = $request->email;
            $Order->theme = $request->theme;
            $Order->message = $request->message;
            $Order->address = $request->address;
            $Order->apartments_type = $request->apartments_type;
            $Order->apartments_square = $request->apartments_square;
            $Order->type_building_id = $request->type_building_id;
            $Order->type_bathroom_id = $request->type_bathroom_id;
            $Order->design_id = $request->design_id;
            $Order->phone = $request->phone;
            $Order->status = $request->status;
            $Order->save();

            if ($request->design_option_id) {
                $Order->DesignOptions()->sync($request->design_option_id);
            } else {
                $Order->DesignOptions()->sync([]);
            }

            if ($request->option_id) {
                $Order->Options()->sync($request->option_id);
            } else {
                $Order->Options()->sync([]);
            }

        } catch (Exception $e) {
            return redirect('/home/orders/'.$Order->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }

        return redirect('/home/orders/'.$Order->id.'/edit/')->with(['success'=>['Заказ изменен']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Order = Order::find($id);
        $nameOfDelete = $Order->email;
        $Order->delete();
        return redirect('/home/orders/')->with(['success'=>[$nameOfDelete.' успешно удалена!']]);
    }
}
