<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use Response;
use Hash;
use JWTAuth;

/**
 * @resource Authentication
 * This api will be used in chrome extension in guest mode.
 */
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
     * User Registration API
     * This api will be used in chrome extension as registration wizard.
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

    
    public function rules()
    {
        return [
            'name' => 'required|unique:posts|max:50',
            'email' => 'required|unique:posts|max:50',
            'password' => 'required|unique:posts|max:50',
        ];
    }

    /**
     * User Login API
     * This api will be used in chrome extension as Login wizard.
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
