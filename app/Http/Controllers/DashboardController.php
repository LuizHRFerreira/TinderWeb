<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\characteristics;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\Dashboard;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard.index');
    }

}
