@php
    use App\Models\CharacteristicsOptionsUsers;
@endphp

<!-- Comeca um loop que vai criar um bloco para cada caracteristica -->
@foreach($characteristics as $characteristic)  

    <!-- Cria um bloco para uma caracteristica -->
    <div class="invoice p-3 mb-3">

        <!-- Mostra o nome da caracteristica -->
        <div class="row">
            <p class="h1">{{$characteristic->name}}</p>
            <hr class="bg-dark">
        </div>

        <!-- Mostra a opcao que pode se selecionada -->
        <ul class="list-inline">

            <!-- Comeca um loop que vai adicionar uma opcao com uma checkbox para cada opcao cadastrada com o id da caracteristica -->
            @foreach($options->where('characteristics_id', $characteristic->id) as $option)  

                        <!-- lista uma opcao com uma checkbox -->
                        <li class="list-inline-item">

                        @php
                            # Verifica na tabela CharacteristicsOptionsUsers a linha que contém o id do usuário logado
                            $userOptions = CharacteristicsOptionsUsers::where('users_id', $user->id)->first();

                            # Verifica se a coluna i_seek existe e não é nula antes de tentar decodificar
                            $selectedOptions = [];
                            if ($userOptions && $userOptions->i_seek) {
                                $selectedOptions = json_decode($userOptions->i_seek, true);
                            }

                            # Verifica se as opções listadas na coluna i_seek do usuário estão entre as opções listadas
                            $isChecked = in_array($option->id, $selectedOptions); 
                        @endphp

                            <!-- Type é oque define que é a checkbox, name está fazendo o resultado virar uma array, Value está atribuindo o id da opção quando ela é selecionada e o id é oque permite eu vincular com a label-->
                            <input type="checkbox" name="selected_options[]" value="{{$option->id}}" id={{$option->id}} @checked($isChecked)>

                            <!-- Mostra o nome da opcao -->
                            <label for={{$option->id}}> {{$option->name}} </label>

                        </li>

            @endforeach


        </ul>

    </div>

@endforeach