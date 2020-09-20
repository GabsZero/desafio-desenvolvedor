<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User; 
use Validator;

class UserController extends Controller
{
    public function login(Request $request){ 
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('ComprasSystems')->accessToken; 
            return response()->json(['success' => $success], 200); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $emailExists = User::where('email', $input['email'])->count() > 0;

        //Impedimos de registrar um e-mail que já existe
        if($emailExists) return response()->json(['success' => 'false', 'message' => 'Email already in database']);

        //se não temos esse registro, prosseguimos com a criação do usuário
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('ComprasSystems')->accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], 200); 
    }
}
