<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\characteristics;
use App\Models\Match;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\OptionsDataTable;


class MatchController extends Controller
{
    public function index()
    {   
        $users = User::all();
        return view('match.index', compact('users'));
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
