<?php

namespace App\Http\Controllers;

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
            'status' => 0,
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
//        $orderList = Orders:;

//        return OrderListResource::collection($orderList);

        return response()->json(
            [
                'data' => [
                    'id' => $orders->id,
                    'table' => $orders->table_id,
                    'shift_workers' => $orders->work_shift_id,
                    'create_at' => $orders->create_at,
                    'status' => $orders->status,
                    'price' => $orders->price
                ]
            ], 200
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
                'data' => $order
            ], 200
        );
    }

    public function ShowOrderAll(Request $request, $id)
    {
        //
        $shift = WorkShift::where('user_id', $id)->first();
        $order = Orders::where('work_shift_id', $id)->get();

        $menu = Menu::select('id', 'count', 'position', 'price')->get();
        $priceAll = Menu::select('price')->sum('price');

        return response()->json(
            [
                'data' => [
                    'id' => $order->id,
                    'table' => $order->table_id,
                    'shift_workers' => $order->work_shift_id,
                    'create_at' => $order->create_at,
                    'status' => $order->status,
                    'positions' => $menu,
                    'price_all' => $priceAll
                ]
            ], 200
        );
    }
}
