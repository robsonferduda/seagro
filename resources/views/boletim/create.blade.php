@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@include('boletim._form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-files-o"></i> Novo boletim</h3>
            <p>Envie o PDF e a imagem do boletim; a página de download é montada automaticamente.</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/boletins') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('boletim/novo') }}" enctype="multipart/form-data" id="formBoletim">
        @csrf
        @include('boletim._form')
    </form>
</div>
@endsection

@section('script')
@include('boletim._form_script')
@endsection
