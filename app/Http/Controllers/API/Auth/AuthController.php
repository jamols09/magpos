<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;

class AuthController extends Controller
{
    public function register(Request $request) {
    
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       
        $status = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        if($status) {
            return response()->json(['message' => 'User created.'], 200);
        } else {
            return response()->json(['message' => 'Something Wrong.'], 400);
        }

    }

    public function login(Request $request) {

        if($request->get('username') == '' || $request->get('password') == '') {
            return response(['message' => 'One or more fields are empty.'], 400);
        }

        $req = Request::create(route('passport.token'), 'POST', [
            'Authorization' => 'application/json',
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'username' => $request->username, //this one needs email input instead of username
            'password' => $request->password,
        ]);

        $response = app()->handle($req);

        if ($response->status() == 400) {

            return response(['message' => 'No matching record.'], $response->status());

        } else if ($response->status() == 401) {

            return response(['message' => 'Account not found.'], $response->status());
        }
        
        return $response;
    }

    public function logout(Request $request) {
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => ['success'  => 'See ya soon!']], 200);
    }
}
