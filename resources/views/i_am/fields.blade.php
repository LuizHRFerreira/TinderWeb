@foreach($characteristics as $characteristic)  

    <div class="invoice p-3 mb-3">

        <!-- Mostra o nome da caracteristica -->
        <div class="row">
            <p class="h1">{{$characteristic->name}}</p>
            <hr class="bg-dark">
        </div>

        
        <ul class="list-inline">
            <!-- Comeca um loop que vai adicionar uma opcao com uma checkbox para cada opcao cadastrada com o id da caracteristica -->
            @foreach($options->where('characteristics_id', $characteristic->id) as $option)  
                        <li class="list-inline-item">

                            <input type="checkbox" name="selected_options[]" value="{{$option->id}}" id={{$option->id}} {{ in_array($option->id, old('selected_options', $selectedOptions ?? [])) ? 'checked' : '' }}>
                            <label for={{$option->id}}> {{$option->name}} </label>

                        </li>

            @endforeach

        </ul>

    </div>

@endforeach