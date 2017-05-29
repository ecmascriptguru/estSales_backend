<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use Response;
use Hash;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create session in api side
     *
     * @return json object
     */
    public function signup() {
        $credentials = Input::only('name', 'email', 'password');
        $credentials['password'] = Hash::make($credentials['password']);

        try {
            $user = User::create($credentials);
        } catch (Exception $e) {
            return Response::json(['status' => false, 'message' => 'User already exists.']);
        }

        $token = JWTAuth::fromUser($user);

        return Response::json(
            array('status' => true, 'token' => $token, 'user' => $user)
        );
    }

    /**
     * Create session in api side
     *
     * @return json object
     */
    public function signin() {
        $credentials = Input::only('email', 'password');

        if ( ! $token = JWTAuth::attempt($credentials)) {
            return Response::json(['status' => false, 'message' => 'Credentials are incorrect.']);
        }

        $user = JWTAuth::toUser($token);

        return Response::json(
            array('status' => true, 'token' => $token, 'user' => $user)
        );
    }
}
