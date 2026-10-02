@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-id-card-o"></i> Novo associado</h3>
            <p>Cadastre o associado e envie o link para ele criar a senha da Área do Associado.</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/associados') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('associado-admin') }}" id="formAssociado" novalidate>
        @csrf
        @include('associado_admin._form')
    </form>
</div>
@endsection

@section('script')
@include('associado_admin._form_script')
@endsection
