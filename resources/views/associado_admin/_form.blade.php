@php
    $editando = $associado->exists;
    $temFoto = $editando && $associado->temFoto();
@endphp

<div class="row align-items-start">
    <div class="col-lg-8">
        <div class="nf-panel">
            <div class="nf-panel-title">Dados do associado</div>

            <div class="form-group">
                <label>Nome completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control nf-titulo" name="nome" minlength="5" maxlength="255" required
                       value="{{ old('nome', $associado->nome) }}">
                @error('nome') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>CPF <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="cpf" id="cpf" required inputmode="numeric" placeholder="000.000.000-00"
                               value="{{ old('cpf', $associado->cpf ? $associado->cpfFormatado() : '') }}">
                        <small class="text-danger d-none" id="cpfInvalido">CPF inválido.</small>
                        @error('cpf') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>E-mail particular <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" maxlength="255" required
                               value="{{ old('email', $associado->email) }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <p class="nf-hint mb-0">
                <i class="fa fa-info-circle"></i>
                O associado entra na Área do Associado usando o <strong>CPF</strong> e a senha. O e-mail particular recebe os links de criação e recuperação de senha.
            </p>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">Dados pessoais</div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data de nascimento</label>
                        <input type="date" class="form-control" name="dt_nascimento" max="{{ now()->subDay()->format('Y-m-d') }}"
                               value="{{ old('dt_nascimento', optional($associado->dt_nascimento)->format('Y-m-d')) }}">
                        @error('dt_nascimento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sexo</label>
                        <select class="form-control" name="id_sexo">
                            <option value="">Selecione...</option>
                            @foreach($sexos as $sexo)
                                <option value="{{ $sexo->id }}" {{ (string) old('id_sexo', $associado->id_sexo) === (string) $sexo->id ? 'selected' : '' }}>{{ $sexo->nome }}</option>
                            @endforeach
                        </select>
                        @error('id_sexo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>UF de naturalidade</label>
                        <select class="form-control" name="uf_naturalidade" id="uf_naturalidade" data-uf-cidade="id_cidade_naturalidade">
                            <option value="">UF</option>
                            @foreach($ufs as $uf)
                                <option value="{{ $uf->sigla }}" title="{{ $uf->nome }}" {{ $ufNaturalidade === $uf->sigla ? 'selected' : '' }}>{{ $uf->sigla }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group mb-0">
                        <label>Naturalidade (cidade)</label>
                        <select class="form-control" name="id_cidade_naturalidade" id="id_cidade_naturalidade" {{ $ufNaturalidade ? '' : 'disabled' }}>
                            <option value="">{{ $ufNaturalidade ? 'Selecione...' : 'Selecione a UF' }}</option>
                            @foreach($cidadesNaturalidade as $cidade)
                                <option value="{{ $cidade->id }}" {{ (string) old('id_cidade_naturalidade', $associado->id_cidade_naturalidade) === (string) $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                            @endforeach
                        </select>
                        @error('id_cidade_naturalidade') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">Endereço residencial</div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" class="form-control" name="cep" id="cep" inputmode="numeric" placeholder="00000-000"
                               value="{{ old('cep', $associado->cep) }}">
                        <small class="text-muted d-block" id="cepStatus"></small>
                        @error('cep') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" class="form-control" name="logradouro" id="logradouro" maxlength="255" placeholder="Rua, avenida..."
                               value="{{ old('logradouro', $associado->logradouro) }}">
                        @error('logradouro') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" class="form-control" name="numero" id="numero" maxlength="20"
                               value="{{ old('numero', $associado->numero) }}">
                        @error('numero') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Complemento</label>
                        <input type="text" class="form-control" name="complemento" maxlength="100" placeholder="Apto, bloco..."
                               value="{{ old('complemento', $associado->complemento) }}">
                        @error('complemento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" class="form-control" name="bairro" id="bairro" maxlength="100"
                               value="{{ old('bairro', $associado->bairro) }}">
                        @error('bairro') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label>UF</label>
                        <select class="form-control" name="uf_residencia" id="uf_residencia" data-uf-cidade="id_cidade">
                            <option value="">UF</option>
                            @foreach($ufs as $uf)
                                <option value="{{ $uf->sigla }}" title="{{ $uf->nome }}" {{ $ufResidencia === $uf->sigla ? 'selected' : '' }}>{{ $uf->sigla }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group mb-0">
                        <label>Cidade</label>
                        <select class="form-control" name="id_cidade" id="id_cidade" {{ $ufResidencia ? '' : 'disabled' }}>
                            <option value="">{{ $ufResidencia ? 'Selecione...' : 'Selecione a UF' }}</option>
                            @foreach($cidadesResidencia as $cidade)
                                <option value="{{ $cidade->id }}" {{ (string) old('id_cidade', $associado->id_cidade) === (string) $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                            @endforeach
                        </select>
                        @error('id_cidade') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">Contato</div>

            <div class="form-group">
                <label>E-mail de trabalho</label>
                <input type="email" class="form-control" name="email_trabalho" maxlength="255"
                       value="{{ old('email_trabalho', $associado->email_trabalho) }}">
                @error('email_trabalho') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Celular</label>
                        <input type="text" class="form-control" name="telefone_celular" data-telefone inputmode="numeric" placeholder="(00) 00000-0000"
                               value="{{ old('telefone_celular', $associado->telefone_celular) }}">
                        @error('telefone_celular') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Telefone residencial</label>
                        <input type="text" class="form-control" name="telefone_residencial" data-telefone inputmode="numeric" placeholder="(00) 0000-0000"
                               value="{{ old('telefone_residencial', $associado->telefone_residencial) }}">
                        @error('telefone_residencial') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label>Telefone comercial</label>
                        <input type="text" class="form-control" name="telefone_comercial" data-telefone inputmode="numeric" placeholder="(00) 0000-0000"
                               value="{{ old('telefone_comercial', $associado->telefone_comercial) }}">
                        @error('telefone_comercial') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">
                <span>Senha de acesso</span>
                @if($editando)
                    <small class="text-muted text-normal">
                        {{ $associado->temSenha() ? 'Senha já definida' : 'Ainda sem senha' }}
                    </small>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-1">
                        <label>{{ $editando ? 'Nova senha' : 'Senha inicial' }} <small class="text-muted">(opcional)</small></label>
                        <div class="input-group mb-0">
                            <input type="password" class="form-control" name="password" id="senha" minlength="8" maxlength="100" autocomplete="new-password">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary m-0" id="btnVerSenha" title="Mostrar senha" style="padding:0.4rem 0.7rem;">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block" style="font-size:0.78rem;margin-top:1.9rem;">
                        {{ $editando ? 'Deixe em branco para manter a senha atual.' : 'Deixe em branco para que o próprio associado crie a senha pelo link enviado por e-mail.' }}
                        Mínimo de 8 caracteres.
                    </small>
                </div>
            </div>

            @unless($editando)
                <label class="nf-switch mt-3 mb-0">
                    <span>Enviar link de acesso por e-mail<small>O associado recebe um link (válido por 24h) para criar a própria senha</small></span>
                    <input type="checkbox" name="enviar_acesso" value="1" {{ old('enviar_acesso', $errors->any() ? 0 : 1) ? 'checked' : '' }}>
                </label>
            @endunless
        </div>
    </div>

    <div class="col-lg-4">
        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Foto</div>

            <div class="nf-foto-moldura">
                <img id="fotoPreview" alt="Foto do associado" class="{{ $temFoto ? '' : 'd-none' }}"
                     src="{{ $temFoto ? url('associado-admin/' . $associado->id . '/foto?v=' . urlencode($associado->foto)) : '' }}">
                <span id="fotoVazia" class="{{ $temFoto ? 'd-none' : '' }}"><i class="fa fa-user"></i></span>
            </div>

            <label class="nf-file mb-0" for="foto">
                <span class="nf-file-icone"><i class="fa fa-camera"></i></span>
                <span class="nf-file-texto">
                    <strong>{{ $temFoto ? 'Substituir foto' : 'Enviar foto' }}</strong>
                    <span class="nf-file-nome">Clique para selecionar</span>
                    <small>Rosto, tipo 3x4 · JPG, PNG ou WEBP · até 5MB</small>
                </span>
                <input type="file" name="foto" id="foto" class="nf-file-input" accept="image/jpeg,image/png,image/webp" data-foto-preview>
            </label>
            <small class="text-danger d-block" id="fotoStatus"></small>
            @error('foto') <small class="text-danger d-block">{{ $message }}</small> @enderror

            @if($temFoto)
                <label class="nf-check mt-2 mb-0">
                    <input type="checkbox" name="remover_foto" id="remover_foto" value="1"> Remover foto atual
                </label>
            @endif
        </div>

        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Acesso</div>

            <label class="nf-switch mb-0">
                <span>Acesso liberado<small>Desmarque para bloquear a entrada na Área do Associado</small></span>
                <input type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', $errors->any() ? 0 : ($associado->fl_ativo ? 1 : 0)) ? 'checked' : '' }}>
            </label>
        </div>

        @if($editando)
            <div class="nf-panel nf-panel-side">
                <div class="nf-panel-title">Informações</div>
                <div class="nf-info">Origem: <strong>{{ $associado->origem === \App\Models\Associado::ORIGEM_SITE ? 'Cadastro pelo site' : 'Cadastrado no painel' }}</strong></div>
                @if($associado->created_at)
                    <div class="nf-info">Cadastrado em: <strong>{{ $associado->created_at->format('d/m/Y H:i') }}</strong></div>
                @endif
                @if($associado->updated_at)
                    <div class="nf-info">Atualizado em: <strong>{{ $associado->updated_at->format('d/m/Y H:i') }}</strong></div>
                @endif
                <div class="nf-info mb-0">Último acesso: <strong>{{ $associado->dt_ultimo_acesso ? $associado->dt_ultimo_acesso->format('d/m/Y H:i') : 'Nunca acessou' }}</strong></div>
            </div>
        @endif

        <div class="nf-actions">
            <a href="{{ url('gercont/associados') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-success" id="btnSalvar">
                <i class="fa fa-save"></i> {{ $editando ? 'Salvar alterações' : 'Salvar associado' }}
            </button>
        </div>
    </div>
</div>
