@php
    $editando = isset($publicacao) && $publicacao->exists;
    $arquivoAtual = $editando && $publicacao->arquivo ? $publicacao->arquivo : null;
@endphp

@if($arquivoAtual)
    <input type="hidden" name="arquivo_atual" value="{{ $arquivoAtual }}">
@endif

<div class="row align-items-start">
    <div class="col-lg-8">
        <div class="nf-panel">
            <div class="nf-panel-title">Conteúdo</div>

            <div class="form-group">
                <label>Título <span class="text-danger">*</span></label>
                <input type="text" class="form-control nf-titulo" name="titulo" minlength="3" maxlength="255" required
                       placeholder="Ex.: Revista 40 Anos do SEAGRO-SC"
                       value="{{ old('titulo', $editando ? $publicacao->titulo : '') }}">
                @error('titulo') <small class="text-danger">{!! $message !!}</small> @enderror
            </div>

            <div class="form-group mb-0">
                <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                <input type="text" class="form-control" name="subtitulo" maxlength="500"
                       placeholder="Texto complementar curto exibido abaixo do título"
                       value="{{ old('subtitulo', $editando ? $publicacao->subtitulo : '') }}">
                @error('subtitulo') <small class="text-danger">{!! $message !!}</small> @enderror
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">
                <span>Arquivo <span class="text-danger">*</span></span>
                <small class="text-muted text-normal">Envie um arquivo ou informe um link</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="nf-file" for="arquivo">
                        <span class="nf-file-icone pdf"><i class="fa fa-file-pdf-o"></i></span>
                        <span class="nf-file-texto">
                            <strong>Enviar arquivo</strong>
                            <span class="nf-file-nome" data-padrao="{{ $arquivoAtual ? 'Clique para substituir' : 'Clique para selecionar' }}">{{ $arquivoAtual ? 'Clique para substituir' : 'Clique para selecionar' }}</span>
                            <small>PDF, DOC ou DOCX · até 20MB</small>
                        </span>
                        <input type="file" name="arquivo" id="arquivo" class="nf-file-input" accept=".pdf,.doc,.docx">
                    </label>
                    @if($arquivoAtual)
                        <a href="{{ $publicacao->link_externo ? asset(ltrim($arquivoAtual, '/')) : $publicacao->linkPublico() }}" target="_blank" rel="noopener" class="nf-file-atual">
                            <i class="fa fa-paperclip"></i> Atual: {{ $arquivoAtual }}
                        </a>
                    @endif
                    @error('arquivo') <small class="text-danger d-block">{!! $message !!}</small> @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-1">
                        <label>ou link externo</label>
                        <input type="text" class="form-control" name="link_externo" id="link_externo" maxlength="500"
                               value="{{ old('link_externo', $editando ? $publicacao->link_externo : '') }}"
                               placeholder="https://... ou /caminho/arquivo.pdf">
                        @error('link_externo') <small class="text-danger d-block">{!! $message !!}</small> @enderror
                    </div>
                    <small class="text-muted" style="font-size:0.75rem;">
                        Use se o material estiver hospedado em outro site. Quando preenchido, o link tem prioridade sobre o arquivo.
                    </small>
                </div>
            </div>

            <p class="nf-hint mb-0">
                <i class="fa fa-info-circle"></i>
                Arquivos enviados ficam em <code>public/publicacoes/</code>. Ao enviar um novo arquivo, o link externo é limpo automaticamente.
            </p>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Publicação</div>

            <label class="nf-switch">
                <span>Ativa<small>Exibida na página Publicações do site</small></span>
                <input type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', $editando ? $publicacao->fl_ativo : 1) ? 'checked' : '' }}>
            </label>

            <div class="form-group mb-0 mt-2">
                <label>Ordem de exibição</label>
                <input type="number" class="form-control" name="nu_ordem" min="0"
                       value="{{ old('nu_ordem', $editando ? $publicacao->nu_ordem : 0) }}">
                <small class="text-muted" style="font-size:0.72rem;">Menor número aparece primeiro; empates seguem a ordem alfabética.</small>
                @error('nu_ordem') <small class="text-danger d-block">{!! $message !!}</small> @enderror
            </div>
        </div>

        @if($editando && $publicacao->created_at)
            <div class="nf-panel nf-panel-side">
                <div class="nf-panel-title">Informações</div>
                <div class="nf-info">Cadastrada em: <strong>{{ $publicacao->created_at->format('d/m/Y H:i') }}</strong></div>
                @if($publicacao->updated_at)
                    <div class="nf-info mb-0">Atualizada em: <strong>{{ $publicacao->updated_at->format('d/m/Y H:i') }}</strong></div>
                @endif
            </div>
        @endif

        <div class="nf-actions">
            <a href="{{ url('gercont/publicacoes') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-success" id="btnSalvar">
                <i class="fa fa-save"></i> {{ $editando ? 'Salvar alterações' : 'Salvar publicação' }}
            </button>
        </div>
    </div>
</div>
