@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        @include('associado._topo')

        @if(session('sucesso'))
            <div class="alert alert-success as-alerta"><i class="bi bi-check-circle-fill"></i> {{ session('sucesso') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <div class="as-card as-bloco">
                    <div class="as-bloco-titulo"><span><i class="bi bi-person-vcard"></i> Dados de cadastro</span></div>

                    @if($errors->any())
                        <div class="alert alert-danger as-alerta">
                            @foreach($errors->all() as $erro)
                                <div><i class="bi bi-exclamation-triangle-fill"></i> {{ $erro }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('associado.dados') }}" class="as-form" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label>CPF</label>
                            <input type="text" class="form-control" value="{{ $associado->cpfFormatado() }}" readonly>
                            <small class="as-ajuda">Para corrigir o CPF, entre em contato com o sindicato.</small>
                        </div>
                        <div class="mb-3">
                            <label for="nome">Nome completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="255" autocomplete="name"
                                   value="{{ old('nome', $associado->nome) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="255" autocomplete="email"
                                   value="{{ old('email', $associado->email) }}" required>
                            <small class="as-ajuda">É para este e-mail que enviamos o link de recuperação de senha.</small>
                        </div>
                        <button type="submit" class="btn as-btn"><i class="bi bi-check2"></i> Salvar dados</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="as-card as-bloco">
                    <div class="as-bloco-titulo"><span><i class="bi bi-shield-lock"></i> Alterar senha</span></div>

                    @if($errors->senha->any())
                        <div class="alert alert-danger as-alerta">
                            @foreach($errors->senha->all() as $erro)
                                <div><i class="bi bi-exclamation-triangle-fill"></i> {{ $erro }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('associado.senha.alterar') }}" class="as-form" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="senha_atual">Senha atual</label>
                            <div class="as-senha">
                                <input type="password" class="form-control" id="senha_atual" name="senha_atual" autocomplete="current-password" required>
                                <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nova_senha">Nova senha</label>
                            <div class="as-senha">
                                <input type="password" class="form-control" id="nova_senha" name="password" minlength="8" autocomplete="new-password" required>
                                <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                            </div>
                            <small class="as-ajuda">Mínimo de 8 caracteres.</small>
                        </div>
                        <div class="mb-3">
                            <label for="nova_senha_confirmation">Confirme a nova senha</label>
                            <div class="as-senha">
                                <input type="password" class="form-control" id="nova_senha_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password" required>
                                <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                        <button type="submit" class="btn as-btn"><i class="bi bi-key"></i> Alterar senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('associado._script')
@endsection
