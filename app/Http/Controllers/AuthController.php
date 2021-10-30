<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use View;
use Redirect;
use App\Models\User;

class AuthController extends Controller {
    
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['show', 'do', 'logout', 'register', 'doRegister']]);
    }
    
    public function show() {
        if (Auth::check()) 
            return Redirect::route('home');

        return View::make('auth/login');
    }

    public function do(Request $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Auth::attempt($data);
        
        if (!$token = Auth::attempt($data)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (Auth::check()) {
            //Login Success
            return response()->json([
                'message' => 'success',
                'data' => Auth::user(),
                'token' => $token
            ]);

        } else { // false
            //Login Fail
            return response()->json([
                'message' => 'error',
                'data' => [],
                'token' => ''
            ]);
        }
    }

    public function register() {
        if (Auth::check()) 
            return Redirect::route('home');

        return View::make('auth/register');
    }
    
    public function doRegister(Request $request) {
        $emailAlready = User::where('email', $request->email)->first();
        
        if ($emailAlready) {
            //Register Fail
            return response()->json([
                'message' => 'email already',
                'data' => []
            ]);
        }
        
        $user = new User;
        $user->id = $user::max('id') + 1;
        $user->name = ucwords(strtolower($request->name1)) . ' ' . ucwords(strtolower($request->name2)) . ' ' . ucwords(strtolower($request->name3));
        $user->email = strtolower($request->email);
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user = $user->save();

        if ($user) {
            //Register Success
            return response()->json([
                'message' => 'success',
                'data' => $user
            ]);
        } else { // false
            //Register Fail
            return response()->json([
                'message' => 'error',
                'data' => []
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}