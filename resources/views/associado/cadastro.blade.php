@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        <div class="as-card as-auth as-auth-largo">
            @include('associado._lado')

            <div class="as-auth-form">
                <h3>Criar cadastro</h3>
                <p class="as-sub">Leva menos de um minuto. Você usará o CPF e a senha para entrar.</p>

                @include('associado._alertas')

                <form method="POST" action="{{ route('associado.cadastro') }}" class="as-form" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="nome">Nome completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" maxlength="255" autocomplete="name"
                               value="{{ old('nome') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" data-cpf inputmode="numeric" autocomplete="username"
                               placeholder="000.000.000-00" value="{{ old('cpf') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="255" autocomplete="email"
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_confirmation">Confirme o e-mail</label>
                            <input type="email" class="form-control" id="email_confirmation" name="email_confirmation" maxlength="255" autocomplete="off"
                                   value="{{ old('email_confirmation') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password">Senha</label>
                            <div class="as-senha">
                                <input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password" required>
                                <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                            </div>
                            <small class="as-ajuda">Mínimo de 8 caracteres.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation">Confirme a senha</label>
                            <div class="as-senha">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password" required>
                                <button type="button" aria-label="Mostrar senha"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn as-btn w-100"><i class="bi bi-person-plus"></i> Criar cadastro</button>
                </form>

                <div class="as-links">
                    Já tem cadastro? <a href="{{ route('associado.login') }}">Entrar</a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('associado._script')
@endsection
