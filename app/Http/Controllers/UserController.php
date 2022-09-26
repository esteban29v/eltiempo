<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;

Use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(UserRequest $request) {

        try{

            $input = $request->only('name', 'email', 'password');

            $user = new User;

            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = bcrypt($input['password']);

            $user->save();

            return response()->json([
                'res' => true,
                'msg' => 'User created successfully',
                'token' => $user->createToken('user_token')->plainTextToken,
            ]);

        }catch(\Exception $e) {

            return response()->json([
                'res' => false,
                'msg' => 'An error occurred while creating the user' 
            ], 500);
        }

    }

    public function index() {

        $users = User::all();

        return response()->json([
            'res' => true,
            'users' => $users
        ]);
    }

    public function show($id) {

        $user = User::findOrFail($id)->first();

        return response()->json([
            'res' => true,
            'user' => $user
        ]);
    }

    public function attemptLogin(LoginRequest $request) {

        try{

            $credentials = $request->only('email', 'password');

            if(!Auth::attempt($credentials)) {
                return response()->json([
                    'res' => false,
                    'msg' => 'Credentials do not match records',
                ], 401);
            }

            return response()->json([
                'res' => true,
                'msg' => 'User logged in successfully',
                'token' => User::where('email', $credentials['email'])
                            ->first()
                            ->createToken('user_token')
                            ->plainTextToken,
            ]);

        }catch(\Exception $e) {

            return response()->json([
                'res' => false,
                'msg' => 'An error occurred while login' 
            ], 500);
        }
    }
}
