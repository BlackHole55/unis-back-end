<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function signin(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|min:3|max:60',
            'password' =>  'required'
        ]);

        //Check name
        $admin  = Admin::where('name', $fields['name'])->first();

        //Check password
        if(!$admin || !Hash::check($fields['password'], $admin->password))
        {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Wrong username or password'
            ], 401);
        }

        $token = $admin->createToken('myAppToken')->plainTextToken;

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();
        $admin->last_login_timestamp = $formattedDate;
        $admin->save();

        $response = [
            'user' => $admin,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function signup(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|unique:admins|string|min:3|max:60',
            'password' => 'required|min:8|confirmed'
        ]);

        $date = Carbon::now();
        $date->timezone('Asia/Aqtobe');
        $formattedDate = $date->toIso8601String();

        $admin = Admin::create([
            'name' => $fields['name'],
            'password' => bcrypt($fields['password']),
            'registered_timestamp' => $formattedDate,
        ]);

        $token = $admin->createToken('myAppToken')->plainTextToken;

        $response = [
            'token' => $token,
            'status' => 'success',
        ];

        return response()->json($response, 201);
    }

    public function signout(Request $request)
    {
        if(Auth::check()){
            auth()->user()->tokens()->delete();    
        };

        $response = [
            'status' => 'success',
        ];

        return response()->json($response, 200);
    }

    public function checkLogin(Request $request)
    {   
        if(Auth::check()){
            return response()->json([
                'status' => 'logged in'
            ], 200);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'message' => 'Unauthorized',
        ], 401);
    }
}
