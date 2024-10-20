<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Models\Api;

use DB;
use Str;

class ApiController extends Controller {
    
    public function postApiUserLogin(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        $data = $request->all();
        $username = $data['username'];
        $password = $data['password'];
        
        $sqlUsername = DB::table('users')
                ->where('username', '=', $username)
                ->first();
        if($sqlUsername == null){
            return response()->json([
                "status" => 0,
                "message" => "Data user not found",
                "data" => null
            ]);
        }
        if (Hash::check($password, $sqlUsername->password)) {
            $modelApi = New Api;
            $dataParam = array(
                'object_id' => $modelApi->get_encode($sqlUsername->id),
                'username' => $sqlUsername->username
            );
            return response()->json([
                "status" => 1,
                "message" => null,
                "data" => $dataParam
            ]);
        }
        if($sqlUsername == null){
            return response()->json([
                "status" => 0,
                "message" => "Data user not found",
                "data" => null
            ]);
        }

        
    }
    
    
    
    
}