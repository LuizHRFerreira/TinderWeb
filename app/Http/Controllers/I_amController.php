<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\characteristics;
use App\Models\Option;

class I_amController extends Controller
{

    # Retorna a view para a pessoa escolher as opções das características que ela tem
    public function profile()
    {
        $users = User::all();
        $user = \Auth::user();
        $characteristics = Characteristics::all();
        $options = Option::all();
        return view('i_am.profile', compact('user', 'users', 'characteristics', 'options'));
    }

    # Atualiza os dados do usuário
    public function update(Request $request)
    {
        \DB::beginTransaction();
        
        # Validação dos campos
        try {
            $user = User::find(request()->user_id);
            $user->name = $request->name;
            $user->email = $request->email;

            # Verifica se o campo de senha foi preenchido e se foi, atualiza a senha
            if($request->password) {
                $user->password = Hash::make($request->password);
            }
            # Verifica se o campo de foto foi preenchido e se foi, atualiza a foto
            if ($request->hasFile('photo')) {

                # Deleta a foto antiga
               
                    if ($user->photo) {
                        Storage::delete($user->photo);
                    }
                    
                    # Salva a nova foto
                    $path = $request->file('photo')->store('public/photos'); 
                
                    # Salva no banco de dados o caminho da nova foto
                    $user->photo = $path; 
                }

                elseif ($request->delete == 'on' && $user->photo) { 
                    Storage::delete($user->photo);
                    $user->photo = null; 
            } 
            $user->save();

        }catch(\Exception $e){
            dd($e);
            \DB::rollBack();
            Session::flash('error', trans('message.error_on_update'));
            return redirect()->back();
        }

        \DB::commit();

        Session::flash('success', trans('message.success_on_update'));
        return redirect()->back();
    }
}
