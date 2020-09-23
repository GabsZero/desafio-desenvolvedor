<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerType;

class CustomerTypeController extends Controller
{
    public function index(){
        return CustomerType::all();
    }
}
