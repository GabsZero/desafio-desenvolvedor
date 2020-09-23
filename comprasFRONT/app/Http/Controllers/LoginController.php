<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Cookie;


class LoginController extends Controller
{
    public function authenticate(Request $request){
        //attempting to authenticate
        $response = Http::post('http://api.compras.dev/api/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        //retrieving something "usable" from the request 
        $result = json_decode($response->getBody());

        if($result->success ?? false){
            // storing the user's token 
            Cookie::queue("__token", $result->success->token, 60);
            
            
            Session::flash('success', "Logado!");
            return redirect()->route('home');
        } else {
            // failed to authenticate
            $request->flash();
            Session::flash('error', "Usuário e/ou senha inválido");
            return redirect()->back();
        }
    }
}
