<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Cookie;
use Session;

class ClientesController extends Controller
{
    public function create(){
        try{
            $response = Http::withToken(Cookie::get('__token'))->get('http://api.compras.dev/api/customerType');
            $tiposCliente = json_decode($response->getBody());

        } catch(\Exception $e){
            report($e);

            Session::flash('error', $e->getMessage());
            return redirect()->route('home');
        }

        return view('clientes.create', [
            'tiposCliente' => $tiposCliente
        ]);
    }

    public function store(Request $request){
        $inputs = $request->except('_token');
        $response = Http::withToken(Cookie::get('__token'))
            ->post('http://api.compras.dev/api/customer', $inputs);

        $result = json_decode($response->getBody());

        if(!$result->success){
            Session::flash('error', "Erro ao cadastrar cliente. {$result->message}");
        }
        
        Session::flash('success', "Cliente cadastrado com sucesso");
        //rota para cliente show
        return redirect()->back();
    }
}
