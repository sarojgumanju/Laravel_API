<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class AuthController extends Controller
{
    public function register(Request $req){
        // return $req;
        // return Hash::make($req->password);

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if($validator -> fails()){
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ]);
        }

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = $req->password;
        $user->save();
        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json([
            "success" => true,
            'token' => $token, // register huna sath direct login ko lagi
            "message"=> "User registered successfully!"
        ]);
    }
    

    public function login(Request $req){
        // return $req;

        $user = User::where('email', $req->email)->first();

        $token = $user->createToken($user->email)->plainTextToken;

        if ($user && Hash::check($req->password, $user->password)) {
            // Login success

            return response()->json([
                "success" => true,
                "token" => $token,
                "message" => 'Login successfull!'
            ]);
        } else {
            // Invalid credentials
            return response()->json([
                'success' => false,
                'token' => null,
                'message' => 'Invalid credentials'
            ]);
        }
        
    }   


    public function profile(){
        $user = Auth::user();
        return new UserResource($user); // object ma aako data lai chai yesari pathauney tara data array ma aako xa vaney CourseController ma jastai collection ma pathauney
    }

    public function login_response(){
        return response()->json([
            "success" => false,
            "token" => null,
            "message" => "User not logged in!"
        ]);
    }

    public function logOut(){
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'User logout successfull!'
        ]);
    }
}

// Auth → Laravel authentication facade
// user() → method that returns the currently authenticated user

// The returned value is usually an instance of your Laravel User model.

// user() itself is not a variable
// user() itself is not the model
// It is a method that returns the authenticated User model object
