@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        <div class="as-card as-auth">
            @include('associado._lado')

            <div class="as-auth-form">
                <h3>Primeiro acesso ou nova senha</h3>
                <p class="as-sub">
                    Informe seu CPF. Enviaremos para o e-mail do seu cadastro um link para criar uma nova senha.
                </p>

                @include('associado._alertas')

                <form method="POST" action="{{ route('associado.senha.recuperar') }}" class="as-form" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" data-cpf inputmode="numeric" autocomplete="username"
                               placeholder="000.000.000-00" value="{{ old('cpf') }}" required autofocus>
                    </div>
                    <button type="submit" class="btn as-btn w-100"><i class="bi bi-envelope"></i> Enviar link</button>
                </form>

                <div class="as-links">
                    Não tem mais acesso ao e-mail cadastrado? Fale com o sindicato:
                    <a href="mailto:seagro@seagro-sc.org.br">seagro@seagro-sc.org.br</a>
                    <div class="as-sep"></div>
                    <a href="{{ route('associado.login') }}"><i class="bi bi-arrow-left"></i> Voltar para o login</a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('associado._script')
@endsection
