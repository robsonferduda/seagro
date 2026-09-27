@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@include('boletim._form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-files-o"></i> Editar boletim</h3>
            <p>{{ $boletim->titulo }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/boletins') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
            <a href="{{ url('boletim/detalhes', $boletim->dt_publicacao) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-external-link"></i> Ver no site</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ route('boletim.update', $boletim->id) }}" enctype="multipart/form-data" id="formBoletim">
        @csrf
        @method('PUT')
        @include('boletim._form')
    </form>
</div>
@endsection

@section('script')
@include('boletim._form_script')
@endsection
