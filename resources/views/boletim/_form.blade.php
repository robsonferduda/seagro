@php
    $editando = isset($boletim) && $boletim->exists;
    $dataAtual = $editando && $boletim->dt_publicacao ? date('d/m/Y', strtotime($boletim->dt_publicacao)) : date('d/m/Y');
    $imagemAtual = $editando ? $boletim->urlImagem() : null;
    $pdfAtual = $editando && $boletim->arquivo ? asset('boletim/' . $boletim->arquivo) : null;
    $audioAtual = $editando && $boletim->audio ? asset('boletim/' . $boletim->audio) : null;
@endphp

<div class="row align-items-start">
    <div class="col-lg-8">
        <div class="nf-panel">
            <div class="nf-panel-title">Conteúdo</div>

            <div class="form-group">
                <label>Título <span class="text-danger">*</span></label>
                <input type="text" class="form-control nf-titulo" name="titulo" id="titulo" minlength="3" maxlength="255" required
                       placeholder="Ex.: Boletim Campanha Salarial nº 007/2026 - SEAGRO-SC"
                       value="{{ old('titulo', $editando ? $boletim->titulo : '') }}">
                @error('titulo') <small class="text-danger">{!! $message !!}</small> @enderror
            </div>

            <div class="form-group mb-0">
                <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                <input type="text" class="form-control" name="subtitulo" maxlength="255"
                       placeholder="Linha de apoio exibida abaixo do título"
                       value="{{ old('subtitulo', $editando ? $boletim->subtitulo : '') }}">
                @error('subtitulo') <small class="text-danger">{!! $message !!}</small> @enderror
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">
                <span>Arquivos</span>
                @if($editando)
                    <small class="text-muted text-normal">Envie apenas o que quiser substituir</small>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="bl-file {{ $pdfAtual ? 'tem-atual' : '' }}" for="pdf">
                        <span class="bl-file-icone pdf"><i class="fa fa-file-pdf-o"></i></span>
                        <span class="bl-file-texto">
                            <strong>Arquivo PDF @unless($editando)<span class="text-danger">*</span>@endunless</strong>
                            <span class="bl-file-nome" data-padrao="{{ $editando ? 'Clique para substituir' : 'Clique para selecionar' }}">{{ $editando ? 'Clique para substituir' : 'Clique para selecionar' }}</span>
                            <small>PDF · até 10MB</small>
                        </span>
                        <input type="file" name="pdf" id="pdf" class="bl-file-input" accept=".pdf,application/pdf" {{ $editando ? '' : 'required' }}>
                    </label>
                    @if($pdfAtual)
                        <a href="{{ $pdfAtual }}" target="_blank" class="bl-file-atual"><i class="fa fa-paperclip"></i> Atual: {{ $boletim->arquivo }}</a>
                    @endif
                    @error('pdf') <small class="text-danger d-block">{!! $message !!}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="bl-file {{ $audioAtual ? 'tem-atual' : '' }}" for="audio">
                        <span class="bl-file-icone audio"><i class="fa fa-volume-up"></i></span>
                        <span class="bl-file-texto">
                            <strong>Áudio <small class="text-muted">(opcional)</small></strong>
                            <span class="bl-file-nome" data-padrao="{{ $audioAtual ? 'Clique para substituir' : 'Clique para selecionar' }}">{{ $audioAtual ? 'Clique para substituir' : 'Clique para selecionar' }}</span>
                            <small>MP3 ou WAV · até 20MB</small>
                        </span>
                        <input type="file" name="audio" id="audio" class="bl-file-input" accept=".mp3,.wav,audio/*">
                    </label>
                    @if($audioAtual)
                        <a href="{{ $audioAtual }}" target="_blank" class="bl-file-atual"><i class="fa fa-paperclip"></i> Atual: {{ $boletim->audio }}</a>
                    @endif
                    @error('audio') <small class="text-danger d-block">{!! $message !!}</small> @enderror
                </div>
            </div>

            <p class="nf-hint mb-0">
                <i class="fa fa-info-circle"></i>
                Os arquivos são salvos como <code>boletim-AAAA-MM-DD</code> a partir da data de publicação, e a página do boletim
                (link de download + imagem) é gerada automaticamente.
            </p>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Publicação</div>

            <div class="form-group mb-2">
                <label>Data de publicação <span class="text-danger">*</span></label>
                <input type="text" class="form-control datepicker" name="dt_publicacao" required
                       value="{{ old('dt_publicacao', $dataAtual) }}" placeholder="dd/mm/aaaa" autocomplete="off">
                @error('dt_publicacao') <small class="text-danger">{!! $message !!}</small> @enderror
            </div>

            <label class="nf-switch">
                <span>Publicar<small>Visível na lista de boletins do site</small></span>
                <input type="checkbox" name="fl_publicacao" value="1" {{ old('fl_publicacao', $editando ? $boletim->fl_publicacao : 1) ? 'checked' : '' }}>
            </label>
        </div>

        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Imagem do boletim @unless($editando)<span class="text-danger">*</span>@endunless</div>
            <div class="nf-capa-box bl-capa-box">
                <img id="preview-image" src="{{ $imagemAtual }}" alt="" class="bl-capa-preview" style="{{ $imagemAtual ? '' : 'display:none;' }}"
                     onerror="if (!this.src.startsWith('data:')) { this.style.display='none'; document.getElementById('capa-empty').style.display=''; }">
                <div id="capa-empty" class="nf-capa-empty" style="{{ $imagemAtual ? 'display:none;' : '' }}">
                    <i class="fa fa-cloud-upload"></i>
                    JPG ou PNG · até 5MB<br>
                    <small>Exibida na página do boletim</small>
                </div>
                <div class="custom-file text-left">
                    <input type="file" name="imagem" class="custom-file-input" id="imagem" accept=".jpg,.jpeg,.png,image/jpeg,image/png" {{ $editando ? '' : 'required' }}>
                    <label class="custom-file-label" for="imagem">{{ $imagemAtual ? 'Substituir imagem' : 'Selecionar imagem' }}</label>
                </div>
                @error('imagem') <small class="text-danger d-block mt-1">{!! $message !!}</small> @enderror
            </div>
        </div>

        @if($editando)
            <div class="nf-panel nf-panel-side">
                <div class="nf-panel-title">Estatísticas</div>
                <div class="bl-estat">
                    <div><strong>{{ number_format((int) $boletim->acessos, 0, ',', '.') }}</strong><span>Acessos</span></div>
                    <div><strong>{{ number_format((int) $boletim->downloads, 0, ',', '.') }}</strong><span>Downloads</span></div>
                </div>
            </div>
        @endif

        <div class="nf-actions">
            <a href="{{ url('gercont/boletins') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-success" id="btnSalvar">
                <i class="fa fa-save"></i> {{ $editando ? 'Salvar alterações' : 'Salvar boletim' }}
            </button>
        </div>
    </div>
</div>
