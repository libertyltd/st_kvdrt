<?php

namespace App\Http\Controllers;

use App\Design;
use App\DesignOption;
use App\ImageStorage;
use App\Option;
use App\Order;
use App\TypeBathroom;
use App\TypeBuilding;
use App\User;
use App\VariableParam;
use Illuminate\Http\Request;
use Validator;
use Exception;

use App\Http\Requests;
use Illuminate\Http\Response;

class PageConstructorController extends Controller
{
    public function index(Request $request) {
        $typesBuilding = TypeBuilding::where('status', 1)->get();
        $typesBathroom = TypeBathroom::where('status', 1)->get();
        $variableParam = VariableParam::where(['status' => 1, 'parent_id' => null, 'status' => 1])->get();

        return view('frontend.constructor.constructor', [
            'title' => 'Конструктор дизайна',
            'address' => true,
            'typesBuilding' => $typesBuilding,
            'typesBathroom' => $typesBathroom,
            'variableParam' => $variableParam,
        ]);
    }

    public function address(Request $request) {
        date_default_timezone_set('UTC');
        $validator = Validator::make($request->all(), [
            'apartments_type' => 'required|max:255',
            'apartments_square' => 'numeric|required',
            'type_building_id' => 'numeric|required',
            'type_bathroom_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка входных данных',
            ]);
        }

        // подготовим каркас заказа

        session(['orderCarcas' => []]);
        $orderCarcas = [];
        if (isset($request->address)) {
            $orderCarcas['address'] = $request->address;
        }
        $orderCarcas['apartments_type'] = $request->apartments_type;
        $orderCarcas['apartments_square'] = $request->apartments_square;
        $orderCarcas['type_building_id'] = $request->type_building_id;
        $orderCarcas['type_bathroom_id'] = $request->type_bathroom_id;

        $variable_params = [];
        if (isset($request->variable_param_checkbox)) {
            foreach ($request->variable_param_checkbox as $key => $value) {
                $variable_params[] = [
                    'id' => $value,
                    'amount' => !empty($request->variable_param_checkbox_amount[$value])
                        ? $request->variable_param_checkbox_amount[$value]
                        : '',
                ];
            }
        }

        if (isset($request->variable_param_radio)) {
            foreach ($request->variable_param_radio as $key => $value) {
                $variable_params[] = [
                    'id' => $value,
                    'amount' => 1,
                ];
            }
        }


        $orderCarcas['variable_params'] = $variable_params;

        session(['orderCarcas' => $orderCarcas]);

        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);


        // Соберем все дизайны комнат
        $designs = Design::where(['status' => 1])->get();
        $rooms = [];
        foreach ($designs as $design) {
            foreach ($design->CategoryDesigns as $category) {
                $options = $category->DesignOptions()->where(['status' => 1, 'type' => 'room'])->orderBy('price', 'ASC')->get();
                foreach ($options as $option) {

                    //высчитаем цену дизайна исходя из квадратуры и минимальной цены
                    $additionOptions = [];
                    foreach ($variable_params as $item) {
                        $VariableParam = VariableParam::find($item['id']);
                        if (!$VariableParam) continue;
                        if ($VariableParam->is_one) {
                            $additionOptions[] = $VariableParam->price_per_one;
                        } else {
                            $summ = 0;
                            if (is_numeric($item['amount'])) {
                                $summ = $VariableParam->price_per_one * $item['amount'];
                            } else {
                                $summ = $VariableParam->price_per_one;
                            }

                            $additionOptions[] = $summ;
                        }
                        if ($VariableParam->is_square_require) {
                            $additionOptions[count($additionOptions) - 1] = $additionOptions[count($additionOptions) - 1] * $orderCarcas['apartments_square'];
                        }
                    }
                    //вычислили сумму

                    $IM = new ImageStorage($option);
                    $rooms[] = [
                        'id' => $option->id,
                        'img' => $IM->getCropped('photo', 500, 500),
                        'name' => $option->name,
                        'price' => $option->price,
                        'description' => $option->description,
                        'design_price' => $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, $additionOptions, $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient),
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'rooms' => $rooms,
        ]);

    }

    public function rooms (Request $request) {
        $orderCarcas = session('orderCarcas');
        if (!isset($orderCarcas) || empty($orderCarcas)) {
            return response()->json([
                'success' => false,
            ]);
        }
        $roomOptionId = $request->room;

        $designOption = DesignOption::where(['status' => 1, 'id' => $roomOptionId])->first();
        if (!$designOption) {
            return response()->json([
                'success' => false,
            ]);
        }
        $design = $designOption->CategoryDesign->Design;

        //сохраняем id дизайна
        $orderCarcas['room_option_id'] = $roomOptionId;
        $orderCarcas['design_id'] = $design->id;
        session(['orderCarcas' => $orderCarcas]);

        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        if (!$typeBuilding) {
            return response()->json([
                'success' => false,
            ]);
        }
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);
        if (!$typeBathroom) {
            return response()->json([
                'success' => false,
            ]);
        }

        $variable_params = $orderCarcas['variable_params'];

        $additionOptions = [];
        foreach ($variable_params as $item) {
            $VariableParam = VariableParam::find($item['id']);
            if (!$VariableParam) continue;
            if ($VariableParam->is_one) {
                $additionOptions[] = $VariableParam->price_per_one;
            } else {
                $summ = 0;
                if (is_numeric($item['amount'])) {
                    $summ = $VariableParam->price_per_one * $item['amount'];
                } else {
                    $summ = $VariableParam->price_per_one;
                }

                $additionOptions[] = $summ;
            }
            if ($VariableParam->is_square_require) {
                $additionOptions[count($additionOptions) - 1] = $additionOptions[count($additionOptions) - 1] * $orderCarcas['apartments_square'];
            }
        }

        $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, $additionOptions, $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient);
        $summ = $summ + $designOption->price;


        $designs = Design::where(['status' => 1])->get();
        $bathrooms = [];
        foreach ($designs as $design) {
            foreach ($design->CategoryDesigns as $category) {
                $options = $category->DesignOptions()->where(['status' => 1, 'type' => 'bathroom'])->orderBy('price', 'ASC')->get();
                foreach ($options as $option) {
                    $IM = new ImageStorage($option);

                    $bathrooms[] = [
                        'id' => $option->id,
                        'img' => $IM->getCropped('photo', 500, 500),
                        'name' => $option->name,
                        'price' => $option->price,
                        'description' => $option->description,
                        'design_price' => $summ,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'bathrooms' => $bathrooms,
        ]);
    }

    public function bathrooms(Request $request) {
        $orderCarcas = session('orderCarcas');
        if (!isset($orderCarcas) || empty($orderCarcas)) {
            return response()->json([
                'success' => false,
            ]);
        }

        $bathroom = DesignOption::find($request->bathroom);
        if (!$bathroom) {
            return response()->json([
                'success' => false,
            ]);
        }
        $orderCarcas['bathroom_option_id'] = $request->bathroom;
        $orderCarcas['designOptions'] = [$orderCarcas['bathroom_option_id'], $orderCarcas['room_option_id']];
        session(['orderCarcas' => $orderCarcas]);

        $variable_params = $orderCarcas['variable_params'];

        $additionOptions = [];
        foreach ($variable_params as $item) {
            $VariableParam = VariableParam::find($item['id']);
            if (!$VariableParam) continue;
            if ($VariableParam->is_one) {
                $additionOptions[] = $VariableParam->price_per_one;
            } else {
                $summ = 0;
                if (is_numeric($item['amount'])) {
                    $summ = $VariableParam->price_per_one * $item['amount'];
                } else {
                    $summ = $VariableParam->price_per_one;
                }

                $additionOptions[] = $summ;
            }
            if ($VariableParam->is_square_require) {
                $additionOptions[count($additionOptions) - 1] = $additionOptions[count($additionOptions) - 1] * $orderCarcas['apartments_square'];
            }
        }

        $design = Design::find($orderCarcas['design_id']);
        $room = DesignOption::find($orderCarcas['room_option_id']);
        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        if (!$typeBuilding) {
            return response()->json([
                'success' => false,
            ]);
        }
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);
        if (!$typeBathroom) {
            return response()->json([
                'success' => false,
            ]);
        }


        $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, $additionOptions, $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient);
        $summ = $summ + $room->price + $bathroom->price;

        //сформируем список дополнительных опций
        $Options = Option::where('status', '1')->get();
        $preparedOprions = [];
        foreach ($Options as $option) {
            $preparedOprions[] = [
                'id' => $option->id,
                'name' => $option->name,
                'price_formated' => Design::formatPrice($option->getPrice($orderCarcas['apartments_square'] ? $orderCarcas['apartments_square'] : null)),
                'price' => $option->getPrice($orderCarcas['apartments_square'] ? $orderCarcas['apartments_square'] : null),
            ];
        }

        return response()->json([
            'success' => true,
            'design_price' => $summ,
            'options' => $preparedOprions,
        ]);
    }

    public function options(Request $request) {
        $orderCarcas = session('orderCarcas');
        if (!isset($orderCarcas) || empty($orderCarcas)) {
            return response()->json([
                'success' => false,
            ]);
        }

        $bathroom = DesignOption::find($orderCarcas['bathroom_option_id']);
        $room =     DesignOption::find($orderCarcas['room_option_id']);
        $design =   Design::find($orderCarcas['design_id']);
        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);


        $Options = Option::all();
        $optionsArray = [];
        $request = $request->toArray();
        $summOptions = 0;
        foreach ($Options as $option) {
            if (isset($request['option'.$option->id])) {
                $optionsArray[] = $request['option'.$option->id];
                $summOptions += $option->getPrice(!empty($orderCarcas['apartments_square']) ? $orderCarcas['apartments_square'] : null);
            }
        }
        $orderCarcas['options'] = $optionsArray;
        session(['orderCarcas' => $orderCarcas]);


        $variable_params = $orderCarcas['variable_params'];

        $additionOptions = [];
        foreach ($variable_params as $item) {
            $VariableParam = VariableParam::find($item['id']);
            if (!$VariableParam) continue;
            if ($VariableParam->is_one) {
                $additionOptions[] = $VariableParam->price_per_one;
            } else {
                $summ = 0;
                if (is_numeric($item['amount'])) {
                    $summ = $VariableParam->price_per_one * $item['amount'];
                } else {
                    $summ = $VariableParam->price_per_one;
                }

                $additionOptions[] = $summ;
            }
            if ($VariableParam->is_square_require) {
                $additionOptions[count($additionOptions) - 1] = $additionOptions[count($additionOptions) - 1] * $orderCarcas['apartments_square'];
            }
        }

        $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, $additionOptions, $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient);
        $summ = $summ + $room->price + $bathroom->price + $summOptions;

        return response()->json([
            'success' => true,
            'design_price' => $summ,
        ]);
    }

    public function contacts(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка входных данных',
            ]);
        }

        $orderCarcas = session('orderCarcas');
        $orderCarcas['email'] = $request->email;
        $orderCarcas['phone'] = $request->phone;
        session(['orderCarcas' => []]);
        try {

            $users = User::where('send_mail', 1)->get();
            $mailStr = '';
            foreach ($users as $user) {
                if ($mailStr == '') {
                    $mailStr .= $user->email;
                } else {
                    $mailStr .= ', '.$user->email;
                }
            }

            $Order = new Order();
            $Order->email = $orderCarcas['email'];
            $Order->address = $orderCarcas['address'];
            $Order->apartments_type = $orderCarcas['apartments_type'];
            $Order->apartments_square = $orderCarcas['apartments_square'];
            $Order->type_building_id = $orderCarcas['type_building_id'];
            $Order->type_bathroom_id = $orderCarcas['type_bathroom_id'];
            $Order->phone  = $orderCarcas['phone'];
            $Order->design_id = $orderCarcas['design_id'];
            $Order->save();

            $headers  = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: =?utf-8?b?" . base64_encode('kvadrat.space new order handler') . "?= <noreply@kvadrat.space>\r\n";
            mail ($mailStr, "=?utf-8?b?" . base64_encode('Новый заказ с сайта kvadrat.space') . '?=', 'Новый заказ от '.$Order->email.' Доступна по адресу http://kvadrat.space/home/orders/'.$Order->id.'/.', $headers);

            foreach ($orderCarcas['variable_params'] as $item) {
                $VariableParam = VariableParam::find($item['id']);
                if ($VariableParam) {
                    $Order->VariableParams()->save($VariableParam, ['amount' => !empty($item['amount']) ? $item['amount'] : null]);
                }
            }
            $Order->DesignOptions()->sync($orderCarcas['designOptions']);
            $Order->Options()->sync($orderCarcas['options']);
        } catch (Exception $e) {
            //пока ничего не делаем
        }
    }
}
