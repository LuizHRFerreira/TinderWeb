<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\Avaliation;
use Illuminate\Http\Request;



class MatchController extends Controller
{
    
    public function index()
    {   
        // Decodifica um array para um array associativo da coluna i_seek do usuário logado
        $i_seek_ids = json_decode(\Auth::user()->characteristicsOptionsUsers->i_seek ?? '[]', true);

        $alreadyEvaluated = Avaliation::where('avaliator_id', \Auth::user()->id)
        ->pluck('avaliated_id');

        if(!empty($i_seek_ids)){
            // Agora a variável $users recebe o id, nome e foto dos usuários que não são o usuário logado
            $users = User::select('id', 'name', 'photo')
            ->where('id', "!=", \Auth::user()->id)
            ->whereNotIn('id', $alreadyEvaluated)

            // usando o $i_seek_ids para procurar na tabela characteristicsOptionsUsers
            ->whereHas('characteristicsOptionsUsers', function ($query) use ($i_seek_ids) {
                $query->where(function ($q) use ($i_seek_ids) {
                    foreach ($i_seek_ids as $i_seek_id) {
                        // Verifica se o campo i_am (JSON) contém pelo menos um dos valores de i_seek
                            $q->orWhereRaw("JSON_CONTAINS(i_am, ?, '$')", [json_encode($i_seek_id)]);
                        }                
                })
            ->whereNotNull('i_seek') // Garante que i_seek não seja nulo
            ->where('i_seek', '!=', ''); // Garante que i_seek não seja vazio
                })
            
            ->with(['characteristicsOptionsUsers' => function ($query) {
                $query->select('user_id', 'i_am');
            }])

            ->get();

            // Para cada usuário na coleção, verifica se a coluna i_am é um array e, se for, a converte para JSON.
            foreach ($users as $user) {
                $i_am_ids = json_decode($user->characteristicsOptionsUsers->i_am, true) ?? [];
            
                //Recebe os nomes das opções
                $user->i_am_options = Option::whereIn('id', $i_am_ids)->get(); // Use $i_am_ids
          

                // Criei uma variavel dentro de user chamada like. Essa variavel vai receber a avaliação do usuario do card sobre o usuario logado
                $user->like = avaliation::where('avaliated_id', \Auth::user()->id)
                ->where('avaliator_id', $user->id) 
                ->first(); 

                if (empty($user->like)) {
                    $user->like = (object)['like' => 0]; 
                } 

            }

        }
        else{
            $users = [];
        }

            // Envia a view junto com os dados importados
        return view('match.index', compact('users'));
    }

    

    // Função store
    public function store(Request $request) {

        $like = filter_var($request->like, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
       
       $avaliation= new Avaliation;
       $avaliation->avaliator_id = $request->avaliator_id;
       $avaliation->avaliated_id = $request->avaliated_id;
       $avaliation->like = $like;
       $avaliation->save();

    }

}