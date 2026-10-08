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
            <div class="col-lg-8">
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
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="nome">Nome completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" maxlength="255" autocomplete="name"
                                       value="{{ old('nome', $associado->nome) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label>CPF</label>
                                <input type="text" class="form-control" value="{{ $associado->cpfFormatado() }}" readonly>
                                <small class="as-ajuda">Para corrigir, fale com o sindicato.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="dt_nascimento">Data de nascimento</label>
                                <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" autocomplete="bday"
                                       max="{{ now()->subDay()->format('Y-m-d') }}"
                                       value="{{ old('dt_nascimento', optional($associado->dt_nascimento)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="id_sexo">Sexo</label>
                                <select class="form-select" id="id_sexo" name="id_sexo">
                                    <option value="">Selecione...</option>
                                    @foreach($sexos as $sexo)
                                        <option value="{{ $sexo->id }}" {{ (string) old('id_sexo', $associado->id_sexo) === (string) $sexo->id ? 'selected' : '' }}>{{ $sexo->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="uf_naturalidade">UF de naturalidade</label>
                                <select class="form-select" id="uf_naturalidade" name="uf_naturalidade" data-uf-cidade="id_cidade_naturalidade">
                                    <option value="">UF</option>
                                    @foreach($ufs as $uf)
                                        <option value="{{ $uf->sigla }}" title="{{ $uf->nome }}" {{ $ufNaturalidade === $uf->sigla ? 'selected' : '' }}>{{ $uf->sigla }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="id_cidade_naturalidade">Naturalidade (cidade)</label>
                                <select class="form-select" id="id_cidade_naturalidade" name="id_cidade_naturalidade" {{ $ufNaturalidade ? '' : 'disabled' }}>
                                    <option value="">{{ $ufNaturalidade ? 'Selecione...' : 'Selecione a UF' }}</option>
                                    @foreach($cidadesNaturalidade as $cidade)
                                        <option value="{{ $cidade->id }}" {{ (string) old('id_cidade_naturalidade', $associado->id_cidade_naturalidade) === (string) $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4 class="as-subtitulo"><i class="bi bi-house-door"></i> Endereço residencial</h4>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" inputmode="numeric" autocomplete="postal-code" placeholder="00000-000"
                                       value="{{ old('cep', $associado->cep) }}">
                                <small class="as-ajuda d-block" id="cepStatus"></small>
                            </div>
                            <div class="col-md-9">
                                <label for="logradouro">Endereço</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="255" autocomplete="address-line1" placeholder="Rua, avenida..."
                                       value="{{ old('logradouro', $associado->logradouro) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="numero">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" maxlength="20"
                                       value="{{ old('numero', $associado->numero) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" maxlength="100" autocomplete="address-line2" placeholder="Apto, bloco..."
                                       value="{{ old('complemento', $associado->complemento) }}">
                            </div>
                            <div class="col-md-5">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" maxlength="100"
                                       value="{{ old('bairro', $associado->bairro) }}">
                            </div>
                            <div class="col-md-3">
                                <label for="uf_residencia">UF</label>
                                <select class="form-select" id="uf_residencia" name="uf_residencia" data-uf-cidade="id_cidade">
                                    <option value="">UF</option>
                                    @foreach($ufs as $uf)
                                        <option value="{{ $uf->sigla }}" title="{{ $uf->nome }}" {{ $ufResidencia === $uf->sigla ? 'selected' : '' }}>{{ $uf->sigla }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="id_cidade">Cidade</label>
                                <select class="form-select" id="id_cidade" name="id_cidade" {{ $ufResidencia ? '' : 'disabled' }}>
                                    <option value="">{{ $ufResidencia ? 'Selecione...' : 'Selecione a UF' }}</option>
                                    @foreach($cidadesResidencia as $cidade)
                                        <option value="{{ $cidade->id }}" {{ (string) old('id_cidade', $associado->id_cidade) === (string) $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4 class="as-subtitulo"><i class="bi bi-telephone"></i> Contato</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email">E-mail particular</label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="255" autocomplete="email"
                                       value="{{ old('email', $associado->email) }}" required>
                                <small class="as-ajuda">É para este e-mail que enviamos o link de recuperação de senha.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="email_trabalho">E-mail de trabalho</label>
                                <input type="email" class="form-control" id="email_trabalho" name="email_trabalho" maxlength="255"
                                       value="{{ old('email_trabalho', $associado->email_trabalho) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="telefone_celular">Celular</label>
                                <input type="text" class="form-control" id="telefone_celular" name="telefone_celular" data-telefone inputmode="numeric" autocomplete="tel" placeholder="(00) 00000-0000"
                                       value="{{ old('telefone_celular', $associado->telefone_celular) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="telefone_residencial">Telefone residencial</label>
                                <input type="text" class="form-control" id="telefone_residencial" name="telefone_residencial" data-telefone inputmode="numeric" placeholder="(00) 0000-0000"
                                       value="{{ old('telefone_residencial', $associado->telefone_residencial) }}">
                            </div>
                            <div class="col-md-4">
                                <label for="telefone_comercial">Telefone comercial</label>
                                <input type="text" class="form-control" id="telefone_comercial" name="telefone_comercial" data-telefone inputmode="numeric" placeholder="(00) 0000-0000"
                                       value="{{ old('telefone_comercial', $associado->telefone_comercial) }}">
                            </div>
                        </div>

                        <button type="submit" class="btn as-btn mt-4"><i class="bi bi-check2"></i> Salvar dados</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
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
@include('partials.dados_pessoais_script')
@endsection
