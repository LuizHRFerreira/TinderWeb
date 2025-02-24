<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;
use App\Models\Avaliation;
use Illuminate\Http\Request;



class MatchController extends Controller
{
    
    public function index(Request $request)
{
    $i_seek_ids = json_decode(auth()->user()->characteristicsOptionsUsers->i_seek ?? '[]', true);
    $alreadyEvaluated = Avaliation::where('avaliator_id', auth()->user()->id)->pluck('avaliated_id');

    $usersQuery = User::query() // Start with a query builder
        ->select('id', 'name', 'photo')
        ->where('id', '!=', auth()->user()->id)
        ->whereNotIn('id', $alreadyEvaluated);


    if ($i_seek_ids) {  //Only apply the whereHas if $i_seek_ids is not empty
        $usersQuery->whereHas('characteristicsOptionsUsers', function ($query) use ($i_seek_ids) {
          $query->where(function ($q) use ($i_seek_ids) {
              foreach ($i_seek_ids as $i_seek_id) {
                  $q->orWhereRaw("JSON_CONTAINS(i_am, ?, '$')", [json_encode($i_seek_id)]);
              }
          })
          ->whereNotNull('i_seek')
          ->where('i_seek', '!=', '');
      });
    }


    $usersQuery->with(['characteristicsOptionsUsers' => function ($query) {
        $query->select('user_id', 'i_am');
    }]);

    // Busca a quantidade total de usuários para enviar para a view
    $usersRemaining = $usersQuery->count();

    $users = $usersQuery->paginate(30); // Paginate vai mandar 30 usuários por página


    // Criação de um loop que vai ver cada um das opções selecionadas no i_am e colocar o nome da opção
    foreach ($users as $user) {
      $i_am_ids = json_decode($user->characteristicsOptionsUsers->i_am, true) ?? [];
      $user->i_am_options = Option::whereIn('id', $i_am_ids)->get();
      $user->like = Avaliation::where('avaliated_id', auth()->user()->id)
                  ->where('avaliator_id', $user->id)
                  ->first() ?? (object)['like' => 0];
    }


    // Se o controller receber uma solicitação ajax, vai retornar a view match.partials.user_cards que são mais 5 cards
    if ($request->ajax()) {
        return view('match.user_cards', compact('users', 'usersRemaining'));
    }

    return view('match.index', compact('users', 'usersRemaining'));
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