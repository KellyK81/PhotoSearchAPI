<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends AbstractApiController
{
    /**
     * This function will create a user account in the backend.
     */
    public function create(Request $request) { 
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:12|max:64|confirmed',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_BAD_REQUEST);            
        }

        $input = $request->all(); 
        $input['password'] = Hash::make($request->password);

        $user = User::create($input); 

        $accessToken = $user->createToken('authToken')->accessToken;
        
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['message'] = 'User successfully created.';
        $this->jsonResponse['data'] = ['user_token' => $accessToken];
        
        Log::info('User successfully created: '. $request->email);

        return response($this->jsonResponse);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], Response::HTTP_BAD_REQUEST);
        }
        
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check(trim($request->password), $user->password)) {
                $token = $user->createToken('authToken')->accessToken;
                
                $this->jsonResponse['success'] = true;
                $this->jsonResponse['message'] = 'User successfully loggedin!';
                $this->jsonResponse['data'] = [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'user_token' => $token
                ];
                return response($this->jsonResponse);
            } else {
                $this->jsonResponse['message'] = 'Invalid Password!';
                return response($this->jsonResponse, Response::HTTP_BAD_REQUEST);
            }
        }

        $this->jsonResponse['message'] = 'User does not exist.';
        return response($this->jsonResponse, Response::HTTP_BAD_REQUEST);
        
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();

        $this->jsonResponse['success'] = true;
        $this->jsonResponse['message'] = 'You have been successfully logged out!';

        return response($this->jsonResponse);
    }

    public function validateToken(Request $request) {

        $this->jsonResponse['success'] = true;
        $this->jsonResponse['message'] = 'User session is valid';
        $this->jsonResponse['data'] = array('user_id' => request()->user()->id);
        return response($this->jsonResponse);
    }

    public function resetPassword(Request $request) {
        $success = false;
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_\-!@#\$%\^&\*]).*$/',
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_BAD_REQUEST);            
        }
        
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            $this->jsonResponse['success'] = true;
            $this->jsonResponse['message'] = 'Password successfully updated!';
        } else {
            // User is not found
            $invalidEmail['email'] = ['The email entered is incorrect.'];
            return response()->json(['errors' => $invalidEmail], Response::HTTP_BAD_REQUEST);
        }

        return response($this->jsonResponse);
    }
}
