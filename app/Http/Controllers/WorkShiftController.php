<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkShiftController extends Controller
{
    public function createShift(Request $request)
    {
        $user = User::where('user_token', $request->bearerToken())->first();
        $input = [
//            'user_id' => $request->input('id'),
            'start' => $request->input('start'),
            'end' => $request->input('end')
        ];

        $validator = Validator::make($input, [
            'start' => 'required',
            'end' => 'required'
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

        $shift = WorkShift::create($input);

        return response()->json(
            [
                'id' => $shift->id,
                'start' => $shift->start,
                'end' => $shift->end
            ]
        );
    }

    function openShift(Request $request, $id)
    {
        $user = User::where('user_token', $request->bearerToken())->first();
        $shiftCheck = WorkShift::where('user_id', $user->id)->first();
        $shift = WorkShift::find($id, 'id');

        if ($shiftCheck->active == 0) {
            $shift->update([
                'active' => 1
            ]);

            return response()->json(
                [
                    'data' => $shift
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'error' => [
                        'code' => 403,
                        'message' => 'Forbidden. There are open shifts!'
                    ]
                ],
                403
            );
        }
    }

    public function closeShift(Request $request, $id)
    {
        $user = User::where('user_token', $request->bearerToken())->first();

        $shiftCheck = WorkShift::where('user_id', $user->id)->first();
        $shift = WorkShift::find($id, 'id');

        if ($shiftCheck->active == 1) {
            $shift->update([
                'active' => 0
            ]);

            return response()->json(
                [
                    'data' => [
                        'id' => $shift->id,
                        'start' => $shiftCheck->start,
                        'end' => $shiftCheck->end,
                        'active' => 0
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'error' => [
                        'code' => 403,
                        'message' => 'Forbidden. The shift is already closed!'
                    ]
                ],
                403
            );
        }
    }

    public function addUser(Request $request, $id)
    {
        $user = User::where('user_token', $request->bearerToken())->first();
        $workShift = WorkShift::find($id);

        $input = [
            'user_id' => $request->input('user_id')
        ];

        $validator = Validator::make($input, [
            'user_id' => 'required'
        ]);

        if (!$workShift) return response()->json(
            [
                'error' => [
                    'code' => 403,
                    'message' => 'Такой смены нет'
                ]
            ], 403
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => [
                        'code' => 422,
                        'message' => 'Validation error',
                        'errors' => $validator->errors()
                    ]
                ], 422
            );
        }

        if (!$workShift->user_id) {
            $workShift->update($input);

            return response()->json([
                'data' => [
                    'user_id' => $workShift->user_id,
                    'status' => 'added'
                ]
            ]);
        } else {
            return response()->json(
                [
                    'error' => [
                        'code' => 403,
                        'message' => 'Forbidden. The worker is already on shift!'
                    ]
                ], 403
            );
        }

    }
}