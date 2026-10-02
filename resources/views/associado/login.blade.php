@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        <div class="as-card as-auth">
            @include('associado._lado')

            <div class="as-auth-form">
                <h3>Entrar</h3>
                <p class="as-sub">Informe seu CPF e senha para acessar.</p>

                @include('associado._alertas')

                <form method="POST" action="{{ route('associado.login') }}" class="as-form" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" data-cpf inputmode="numeric" autocomplete="username"
                               placeholder="000.000.000-00" value="{{ old('cpf') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <div class="as-senha">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                            <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lembrar" id="lembrar" value="1" {{ old('lembrar') ? 'checked' : '' }}>
                            <label class="form-check-label" for="lembrar" style="font-weight:400;">Manter conectado</label>
                        </div>
                    </div>
                    <button type="submit" class="btn as-btn w-100"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
                </form>

                <div class="as-links">
                    <a href="{{ route('associado.senha.recuperar') }}">Primeiro acesso ou esqueci minha senha</a>
                    <div class="as-sep"></div>
                    Ainda não tem cadastro? <a href="{{ route('associado.cadastro') }}">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('associado._script')
@endsection
