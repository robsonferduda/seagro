@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-id-card-o"></i> Editar associado</h3>
            <p>{{ $associado->nome }} &middot; {{ $associado->cpfFormatado() }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/associados') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
            @if($associado->fl_ativo)
                <button type="submit" form="formEnviarAcesso" class="btn btn-sm btn-info">
                    <i class="fa fa-envelope"></i> {{ $associado->temSenha() ? 'Enviar link de nova senha' : 'Enviar link de acesso' }}
                </button>
            @endif
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('associado-admin/' . $associado->id) }}" id="formAssociado" novalidate>
        @csrf
        @include('associado_admin._form')
    </form>

    <form method="POST" action="{{ url('associado-admin/' . $associado->id . '/enviar-acesso') }}" id="formEnviarAcesso" class="d-none">
        @csrf
    </form>
</div>
@endsection

@section('script')
@include('associado_admin._form_script')
<script>
$('#formEnviarAcesso').on('submit', function (e) {
    e.preventDefault();
    var form = this;
    Swal.fire({
        icon: 'question',
        title: 'Enviar link de acesso?',
        html: 'Um e-mail será enviado para <strong>' + $('<div>').text(@json($associado->email)).html() + '</strong> com um link para criar ou redefinir a senha.',
        showCancelButton: true,
        confirmButtonColor: '#336693',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then(function (result) {
        if (result.isConfirmed || result.value) form.submit();
    });
});
</script>
@endsection
