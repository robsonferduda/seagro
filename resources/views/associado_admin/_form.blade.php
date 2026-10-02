@php
    $editando = $associado->exists;
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
                        <label>E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" maxlength="255" required
                               value="{{ old('email', $associado->email) }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <p class="nf-hint mb-0">
                <i class="fa fa-info-circle"></i>
                O associado entra na Área do Associado usando o <strong>CPF</strong> e a senha. O e-mail recebe os links de criação e recuperação de senha.
            </p>
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
