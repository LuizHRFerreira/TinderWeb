<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class TesteController extends Controller
{

    
    public function index()
    {
        
        return view('Teste.index');

    }


}
