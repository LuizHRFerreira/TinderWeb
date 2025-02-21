@extends('layouts.master')

@section('content')
    <div class="row">

        <div class="col-12">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Criando nova opção para as características cadastradas</h1>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </section>
            <div class="container">
            <form class="from-prevent-multiple-submits"  action="{{ route('options.store') }}" method="post" encwetype="multipart/form-data">
                @csrf
                @include('options.fields')
                <div class="row no-print">
                    <div class="col-12 mt-4">
                        {{-- <a href="{{ route('companies.users.store', ['company_id' => request()->company_id]) }}">
                        <button type="button" class="btn btn-danger float-right">{{ trans('text.cancel') }}</button>
                        </a> --}}
                        <button type="submit" class="btn btn-success float-right from-prevent-multiple-submits" style="margin-right: 5px;">{{ trans('text.save') }}</button>
                    </div>
                </div>
        </div>
   
    </div>
@endsection