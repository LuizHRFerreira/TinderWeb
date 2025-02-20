<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\characteristics;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\Dashboard;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index()
    {
        $characteristics = Characteristics::all();
        $options = Option::all();
        $counts = characteristicsOptionsUsers::pluck('i_seek')
            // transforma o array em array associativo
            ->map(function ($item) {
                return json_decode($item, true); 
            })
            ->flatten()
            ->countBy();

            // Calcula a quantidade total de opções buscadas de cada característica
            $characteristicTotals = []; 
            foreach ($characteristics as $characteristic) {
                $total = 0;

                // Seleciona todas as opções que tenham o id da característica
                foreach ($options->where('characteristics_id', $characteristic->id) as $option) {

                    // Soma na variavel total a contagem da opção
                    $total += $counts->has($option->id) ? $counts[$option->id] : 0;
                }

                // Insere a contagem no array
                $characteristicTotals[$characteristic->id] = $total;
            }

        return view('dashboard.index', compact('characteristics', 'options', 'counts', 'characteristicTotals'));
    }


}
