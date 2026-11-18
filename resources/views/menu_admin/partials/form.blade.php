@php
    $menu = $menu ?? null;
    $idPaiOld = old('id_pai', $menu->id_pai ?? '');
    $idPaginaOld = old('id_pagina', $menu->id_pagina ?? '');
    $flAtivoOld = old('fl_ativo', $menu ? $menu->fl_ativo : 1);
@endphp
<div class="row align-items-start">
    <div class="col-lg-8">
        <div class="nf-panel">
            <div class="nf-panel-title">Identificação</div>

            <div class="form-group">
                <label>Descrição <span class="text-danger">*</span></label>
                <input type="text" class="form-control nf-titulo" name="descricao" id="descricao" required maxlength="100"
                       placeholder="Ex.: Apresentação" value="{{ old('descricao', $menu->descricao ?? '') }}">
            </div>

            <div class="form-group mb-0">
                <label>Apelido <small class="text-muted">(opcional)</small></label>
                <input type="text" class="form-control" name="apelido" id="apelido" maxlength="100"
                       placeholder="Gerado a partir da descrição" value="{{ old('apelido', $menu->apelido ?? '') }}">
            </div>
        </div>

        <div class="nf-panel">
            <div class="nf-panel-title">Destino</div>
            <p class="text-muted mb-3" style="font-size:0.9rem;">
                Escolha uma página cadastrada e/ou informe uma URL. Se informar só a página, a URL vira <code>pagina/{apelido}</code>.
                Menus agrupadores (com submenus) podem ficar sem destino.
            </p>

            <div class="form-group">
                <label>Página vinculada</label>
                <select name="id_pagina" id="id_pagina" class="form-control">
                    <option value="">— Nenhuma —</option>
                    @foreach($paginas as $pagina)
                        <option value="{{ $pagina->id }}"
                                data-apelido="{{ $pagina->apelido }}"
                                {{ (string) $idPaginaOld === (string) $pagina->id ? 'selected' : '' }}>
                            {{ $pagina->titulo }}
                            @if(!$pagina->fl_publicacao) (oculta) @endif
                            — /pagina/{{ $pagina->apelido }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Ex.: Apresentação abre a página de <code>pagina-admin/1/edit</code> no painel e <code>/pagina/apresentacao</code> no site.</small>
            </div>

            <div class="form-group mb-0">
                <label>URL <small class="text-muted">(opcional — link livre)</small></label>
                <input type="text" class="form-control" name="url" id="url" maxlength="500"
                       placeholder="pagina/apresentacao  ou  https://..."
                       value="{{ old('url', $menu->url ?? '') }}">
                <small class="text-muted">Relativa ao site ou absoluta (externa). Preenchida automaticamente ao escolher uma página.</small>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Hierarquia</div>

            <div class="form-group">
                <label>Menu pai</label>
                <select name="id_pai" id="id_pai" class="form-control">
                    <option value="">— Menu principal —</option>
                    @foreach($pais as $pai)
                        <option value="{{ $pai->id }}" {{ (string) $idPaiOld === (string) $pai->id ? 'selected' : '' }}>
                            @if($pai->id_pai)↳ @endif{{ $pai->descricao }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Deixe vazio para menu de primeiro nível.</small>
            </div>

            <div class="form-group mb-0">
                <label>Ordem</label>
                <input type="number" class="form-control" name="ordem" id="ordem" min="0" max="9999"
                       value="{{ old('ordem', $menu->ordem ?? 0) }}">
            </div>
        </div>

        <div class="nf-panel nf-panel-side">
            <div class="nf-panel-title">Status</div>
            <label class="nf-switch">
                <span>Ativo<small>Disponível para uso no site</small></span>
                <input type="checkbox" name="fl_ativo" value="1" {{ $flAtivoOld ? 'checked' : '' }}>
            </label>
        </div>

        <div class="nf-actions">
            <a href="{{ url('gercont/menus') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-success" id="btnSalvar">
                <i class="fa fa-save"></i> {{ $menu ? 'Salvar' : 'Cadastrar' }}
            </button>
        </div>
    </div>
</div>
