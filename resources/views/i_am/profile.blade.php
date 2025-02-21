@extends('layouts.master')

@section('content')

    @include('layouts.tab')
    
    <!-- Formulario -->
    <div class="row">
        <!-- Quando o botão action for clicado, o formulário chamara a função i_am.update que está na I_amControler -->
        <form name="am" enctype="multipart/form-data">
            @csrf
            <!-- Importa os campos que estão na view fields.blade.php da pasta i_am -->
            @include('i_am.fields')

        </form>
    </div>

    <script>
        $(function() {

            $('input[type="checkbox"][name="selected_options[]"]').change(function() {
                
                // Aqui ele vai selecionar o formulario inteiro, vendo qual foi selecionado e qual não e formata-lo com essa função ".serialize()"
                var formData = $('form[name="am"]').serialize();

                // Requisição Ajax
                $.ajax({
                    url:"{{ route('i_am.update', ['user_id' => $user->id]) }}",
                    type:"POST",
                    data: formData,
                    success: function(data) {
                        console.log(data);
                    }
                })


            });
        });
    </script>

@endsection