<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserListResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'login' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        $user = User::create($input);
        $token = $user->user_token = Str::random(60);
        $user->save();

        return response()->json([
            'data' => [
                'id' => $user->id,
                'status' => 'created'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('login', $request->login)
            ->where('password', $request->password)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    'error' => [
                        'code' => 401,
                        'message' => 'Authentication failed'
                    ]
                ],
                401
            );
        }

        return response()->json(
            [
                'data' => [
                    'user_token' => $user->user_token
                ]
            ]
        );
    }

    public function UsersList(Request $request)
    {
        $user = User::select('id', 'name', 'login', 'status', 'role_id')->get();

        return UserListResource::collection($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
