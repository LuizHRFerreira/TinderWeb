<?php

namespace App\Http\Controllers;
use App\Models\characteristics;
use App\Models\Option;
use Illuminate\Support\Facades\Session;
use App\DataTables\OptionsDataTable;


class OptionController extends Controller
{
    public function index(OptionsDataTable $dataTables)
    {    
        $options = Option::all(); 
        return $dataTables->render('options.index', compact('options'));
    }

    public function create() {
        $characteristics = characteristics::all()->toArray();
        return view('options.create', ['characteristics' => $characteristics]);
    }

    public function store() {
        
        $options = new Option;
        $options->name = request()->name;
        $options->characteristics_id = request()->characteristics_id;
        $options->save();

        Session::flash('success', trans('message.success_on_update'));
        return redirect()->route('options.index');
    }
}
