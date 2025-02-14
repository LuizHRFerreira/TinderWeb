@extends('layouts.master')

@section('content')
    <!-- Título no cabeçalho -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>{{ trans('text.i_am') }}</h1>
        </div>
    </section>

    <!-- Formulario -->
    <div class="row">
        <!-- Quando o botão action for clicado, o formulário chamara a função i_am.update que está na I_amControler -->
        <form action="{{ route('i_am.update', ['user_id' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Importa os campos que estão na view fields.blade.php da pasta i_am -->
            @include('i_am.fields')

            <!-- Botão de salvar -->
            <div class="col-12">
                <button type="submit" class="btn btn-success float-right">{{ trans('text.save') }}</button>
            </div>
        </form>
    </div>

@endsection