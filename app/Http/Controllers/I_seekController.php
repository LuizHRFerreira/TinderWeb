<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\characteristics;
use App\Models\Option;
use App\Models\CharacteristicsOptionsUsers;

class I_seekController extends Controller
{

    # Retorna a view para a pessoa escolher as opções das características que ela tem
    # e todos as variáveis (As que começam com $) são passadas para a view
    public function profile()
    {
        
        # Utilizando as models para pegar os dados do banco de dados (as models sestão sendo importadas no início desse arquivo)
        $users = User::all();
        $user = \Auth::user();
        $characteristics = Characteristics::all();
        $CharacteristicsOptionsUsers = CharacteristicsOptionsUsers::all();
        $options = Option::all();
        
        // Busca as opções já selecionadas antes pelo usuário
        $selectedOptions = CharacteristicsOptionsUsers::where('user_id', auth()->id())
        //Proccura a coluna específica
        ->pluck('i_seek')
        // Transforma em array
        ->map(function ($item) {return json_decode($item, true);})->flatten()->toArray();


        # Retornando a view com as variáveis
        return view('i_seek.profile', compact('user', 'users', 'characteristics', 'options','selectedOptions'));
    }

    # Atualiza os dados do usuário
    public function update(Request $request)
    {
        \DB::beginTransaction();

        try {
            $user = \Auth::user(); // Identifica o autor
            $selectedOptions = $request->input('selected_options', []); //Busca as opções selecionadas pelo usuário
            $selectedOptionsJson = json_encode($selectedOptions); // Transforma as opções selecionadas em array para JSON

            // updateOrCreate vai procurar pelo id do usuário e atualizar os dados, caso não encontre, ele cria um novo registro
            CharacteristicsOptionsUsers::updateOrCreate(
                ['user_id' => $user->id], 
                ['i_seek' => $selectedOptionsJson] 
            );

        } catch (\Exception $e) {
            \DB::rollBack();
            Session::flash('error', trans('message.error_on_update'));
            return redirect()->back()->withErrors([$e->getMessage()]); // Include error message for debugging
        }

        \DB::commit();
        Session::flash('success', trans('message.success_on_update'));
        return redirect()->back();
    }

}
