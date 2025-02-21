<?php

namespace App\Http\Controllers;
use App\Models\characteristics;
use Illuminate\Support\Facades\Session;
use App\DataTables\CharacteristicDataTable;


class characteristicsController extends Controller
{

    //Função index, quando chamada, retorna a view index que está na pasta characteristics
    public function index(CharacteristicDataTable $dataTables) {
        $characteristics = Characteristics::all(); 
        return $dataTables->render('characteristics.index', compact('characteristics'));
    }

    //Função create, quando chamada, retorna a view create que está na pasta characteristics
    //Essa view é a tela de cadastro com os campos a serem preenchidos
    public function create() {
        return view('characteristics.create');
    }

    public function edit() {
        return view('characteristics.edit');
    }

    public function delete() {
        return view('characteristics.delete');
    }
    
    public function store() {
        $characteristics = new Characteristics;
        $characteristics->name = request()->name;
        $characteristics->apps_id = env("APP_ID");
        $characteristics->save();

        Session::flash('success', trans('message.success_on_update'));
        return redirect()->route('characteristics.index');
    }

}
