@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-book"></i> Editar publicação</h3>
            <p>{{ $publicacao->titulo }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/publicacoes') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
            @if($publicacao->linkPublico())
                <a href="{{ $publicacao->linkPublico() }}" target="_blank" rel="noopener" class="btn btn-sm btn-info"><i class="fa fa-external-link"></i> Abrir arquivo</a>
            @endif
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ route('publicacao.update', $publicacao->id) }}" enctype="multipart/form-data" id="formPublicacao">
        @csrf
        @method('PUT')
        @include('publicacoes._form')
    </form>
</div>
@endsection

@section('script')
@include('publicacoes._form_script')
@endsection
