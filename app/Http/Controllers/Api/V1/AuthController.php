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
        $credentials = Input::only('name', 'email', 'password', 'expiration_date', 'membership_tier');

        if (strlen($credentials['membership_tier']) > 1) {
            $credentials['membership_tier'] = substr($credentials['membership_tier'], 0, 1);
        }
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

    /**
     *
     */
    public function check() {
        $credentials = Input::only("email");
        $user = User::where(["email" => $credentials["email"]])->get();
        
        if (sizeof($user) > 0) {
            return Response::json(
                array('status' => true, 'user' => $user[0])
            );
        } else {
            return Response::json(
                array('status' => false, 'msg' => "User not found")
            );
        }
    }

    /**
     *  Renew membership tier
     * @param {string} email
     * @param {string} membership_tier
     * @param {string} expiration_date
     */
    public function extend() {
        $params = Input::only('email', 'membership_tier', 'expiration_date');
        if (strlen($params['membership_tier']) > 1) {
            $params['membership_tier'] = substr($params['membership_tier'], 0, 1);
        }
        $user = User::where('email', $params['email'])->get();

        if (sizeof($user) == 0) {
            return Response::json(
                array('status' => false, 'message' => "User Not found")
            );
        } else {
            $user = $user[0];
            $user->membership_tier = $params['membership_tier'];
            $user->expiration_date = $params['expiration_date'];

            if ($user->save()) {
                return Response::json(
                    array('status' => true, 'message' => "Success")
                );
            } else {
                return Response::json(
                    array('status' => false, 'message' => "SQL Error.")
                );
            }
        }
    }

    /**
     *  Renew membership tier
     * @param {string} email
     * @param {string} expiration_date
     */
    public function expire() {
        $params = Input::only('email');
        $user = User::where('email', $params['email'])->get();

        if (sizeof($user) == 0) {
            return Response::json(
                array('status' => false, 'message' => "User Not found")
            );
        } else {
            $user = $user[0];
            $user->membership_tier = "e";

            if ($user->save()) {
                return Response::json(
                    array('status' => true, 'message' => "Success")
                );
            } else {
                return Response::json(
                    array('status' => false, 'message' => "SQL Error.")
                );
            }
        }
    }
}
