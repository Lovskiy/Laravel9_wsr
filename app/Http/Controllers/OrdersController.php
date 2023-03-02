<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChiefOrderResource;
use App\Http\Resources\OrderListResource;
use App\Models\Menu;
use App\Models\Orders;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function createOrder(Request $request)
    {
        $input = [
            'work_shift_id' => $request->input('work_shift_id'),
            'table_id' => $request->input('table_id'),
            'number_of_person' => $request->input('number_of_person'),
            'create_at' => NOW(),
            'status' => 1,
            'price' => 0
        ];

        $validator = Validator::make($input, [
            'work_shift_id' => 'required',
            'table_id' => 'required',
            'number_of_person' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => [
                        'code' => 422,
                        'message' => 'Validation error',
                        'errors' => $validator->errors()
                    ]
                ],
                422
            );
        }

        $orders = Orders::create($input);

        return response()->json(
            [
                'data' => [
                    'id' => $orders->id,
                    'table' => $orders->table->name,
                    //'shift_workers' => $orders->work_shift_id,
                    'shift_workers' => WorkShift::getUserName($orders->work_shift_id),
                    'create_at' => $orders->create_at,
                    'status' => $orders->statused->name,
                    'price' => $orders->price
                ]
            ],
            200
        );
    }

    public function ShowOrder(Request $request, $id)
    {
        //
        $order = Orders::find($id);
        $menu = Menu::select('id', 'count', 'position', 'price')->get();

        $priceAll = Menu::select('price')->sum('price');
        return response()->json(
            [
                'data' => [
                    'id' => $order->id,
                    'table' => $order->table->name,
                    'shift_workers' => WorkShift::getUserName($order->work_shift_id),
                    'create_at' => $order->create_at,
                    'status' => $order->statused->name,
                    'positions' => $menu,
                    'price_all' => $priceAll
                ]
            ],
            200
        );
    }

    public function ShowOrderAll(Request $request, $id)
    {
//        $priceAll = Menu::select('price')->sum('price');

        $getShift = WorkShift::select('id', 'start', 'end', 'active')
            ->where('id', $id)->first();
        $getOrder = Orders::select('id', 'table_id', 'work_shift_id', 'create_at', 'status', 'price')
            ->where('work_shift_id', $id)->get();
        $order = Orders::find($id);


        return OrderListResource::collection($getOrder, $order);
    }

    public function editOrderStatus(Request $request, $id)
    {
        $order = Orders::where('id', $id)->first();


        // Todo: дома додумать, как сделать нормальное обновление, в голову лезут костыли, so sorry
    }


    public function getChiefOrder(Request $request)
    {
        $orders = Orders::select('id', 'table_id', 'work_shift_id', 'create_at', 'status', 'price')
            ->where('status', '<', 3)
            ->get();

        return ChiefOrderResource::collection($orders);


        // Todo: продумать вывод, скорее всего придется через коллекцию выводить, но я не уверен

//        return response()->json(
//            [
//                'data' => [
//                    'id' => $orders->id,
//                    'table' => $orders->table->name,
//                    'shift_workers' => WorkShift::getUserName($orders->work_shift_id),
//                    'create_at' => $orders->create_at,
//                    'status' => $orders->statused->name,
//                    'price' => $orders->price
//                ]
//            ],
//            200
//        );
    }
}
