@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        <div class="as-card as-auth">
            @include('associado._lado')

            <div class="as-auth-form">
                <h3>Criar nova senha</h3>
                <p class="as-sub">Confirme seu CPF e escolha a senha que usará para entrar.</p>

                @include('associado._alertas')

                <form method="POST" action="{{ route('associado.senha.redefinir.salvar') }}" class="as-form" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" data-cpf inputmode="numeric" autocomplete="username"
                               placeholder="000.000.000-00" value="{{ old('cpf') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password">Nova senha</label>
                        <div class="as-senha">
                            <input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password" required>
                            <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                        </div>
                        <small class="as-ajuda">Mínimo de 8 caracteres.</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation">Confirme a nova senha</label>
                        <div class="as-senha">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password" required>
                            <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn as-btn w-100"><i class="bi bi-shield-lock"></i> Salvar senha e entrar</button>
                </form>

                <div class="as-links">
                    O link expirou? <a href="{{ route('associado.senha.recuperar') }}">Solicite outro</a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('associado._script')
@endsection
