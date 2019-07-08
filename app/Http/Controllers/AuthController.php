<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $registerRule = [
        'name' => 'required | max:100',
        'email' => 'required | max:100',
        'password' => 'required | min:8',
    ];

    protected $loginRule = [
        'email' => 'required | max:100',
        'password' => 'required | min:8',
    ];

    public function register(Request $request)
    {
        $this->validator($request->all(),$this->registerRule)->validate();
        $newUser = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);

        return $this->responseWithToken($token);
    }

    public function login(Request $request)
    {
        $this->validate($request, $this->loginRule);
        $credentials = $request->only(['email','password']);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'state' => 'Unauthorized',
                    'data' => [
                        'message' => 'Email or Password incorrect.'
                    ]
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'state' => 'error',
                'data' => [
                    'message' => 'Fail to login.'
                ]
            ],500);
        }
        return $this->responseWithToken($token);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate($token);
            return response()->json([
                'state' => 'success',
                'data' => [
                    'message' => 'Logout'
                ]
            ],200);
        } catch (JWTException $e) {
            return response()->json([
                'state' => 'error',
                'data' => [
                    'message' => 'Fail to logout.'
                ]
            ],500);
        }
    }

    protected function validator(array $data,$rule)
    {
        return Validator::make($data, $rule);
    }

    public function responseWithToken($token)
    {
        return response()->json([
            'state' => 'success',
            'data' => [
                'token' => $token
            ],
        ],200);
    }
}
