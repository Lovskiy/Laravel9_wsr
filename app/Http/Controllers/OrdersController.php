<?php

namespace App\Http\Controllers;

use App\Models\Orders;
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
            'status' => 'Принят',
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
                    'table' => $orders->table_id,
                    'shift_workers' => $orders->work_shift_id,
                    'create_at' => $orders->create_at,
                    'status' => $orders->status,
                    'price' => $orders->price
                ]
            ], 200
        );
    }
}
