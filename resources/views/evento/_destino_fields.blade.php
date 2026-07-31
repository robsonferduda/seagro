@php
    $tpDestino = old('tp_destino', isset($evento) ? ($evento->tp_destino ?: 'conteudo') : 'conteudo');
    $urlDestino = old('url_destino', isset($evento) ? $evento->url_destino : '');
    $flNovaAba = old('fl_nova_aba', isset($evento) ? $evento->fl_nova_aba : 0);
    $descricao = old('descricao', isset($evento) ? $evento->descricao : '');
@endphp

<style>
    .destino-option {
        cursor: pointer;
        transition: border-color .15s ease, box-shadow .15s ease;
        background: #fff;
    }
    .destino-option:hover {
        border-color: #51bcda !important;
    }
    .destino-option.is-selected {
        border-color: #51bcda !important;
        box-shadow: 0 0 0 0.15rem rgba(81, 188, 218, 0.25);
    }
    .destino-option input[type="radio"] {
        position: static !important;
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
        margin-right: 8px;
        width: auto !important;
        height: auto !important;
    }
    .painel-destino.d-none-destino {
        display: none !important;
    }
</style>

<div class="col-md-12 mt-3">
    <hr>
    <h5 class="mb-3"><i class="fa fa-external-link"></i> Como o evento deve abrir?</h5>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label class="d-block border rounded p-3 mb-2 destino-option {{ $tpDestino === 'conteudo' ? 'is-selected' : '' }}" data-destino="conteudo">
                    <input type="radio" name="tp_destino" value="conteudo" {{ $tpDestino === 'conteudo' ? 'checked' : '' }}>
                    <strong>Página própria</strong>
                    <small class="d-block text-muted mt-1">Abre a página de detalhes do evento com o conteúdo cadastrado.</small>
                </label>
            </div>
            <div class="col-md-6">
                <label class="d-block border rounded p-3 mb-2 destino-option {{ $tpDestino === 'redirect' ? 'is-selected' : '' }}" data-destino="redirect">
                    <input type="radio" name="tp_destino" value="redirect" {{ $tpDestino === 'redirect' ? 'checked' : '' }}>
                    <strong>Redirecionar</strong>
                    <small class="d-block text-muted mt-1">Ao clicar no evento, envia o visitante para outra URL (notícia, Sympla, página externa, etc.).</small>
                </label>
            </div>
        </div>
        @error('tp_destino')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="col-md-12 mt-2 painel-destino {{ $tpDestino === 'conteudo' ? '' : 'd-none-destino' }}" id="painel-conteudo">
    <div class="form-group">
        <label for="descricao">Conteúdo / Descrição <small class="text-muted">(opcional)</small></label>
        <textarea class="form-control" name="descricao" id="descricao" rows="10" placeholder="Texto, links e informações do evento...">{{ $descricao }}</textarea>
        <small class="form-text text-muted">
            <i class="fa fa-info-circle"></i>
            Formatação disponível: negrito, itálico, listas, links e títulos.
            A <strong>imagem/PDF</strong> do evento deve ser enviada no campo de arquivo acima.
        </small>
        @error('descricao')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="col-md-12 mt-2 painel-destino {{ $tpDestino === 'redirect' ? '' : 'd-none-destino' }}" id="painel-redirect">
    <div class="alert alert-warning py-2">
        <i class="fa fa-link"></i> Informe para onde o visitante será enviado ao clicar neste evento.
    </div>
    <div class="form-group">
        <label for="url_destino">URL de destino <span class="text-danger">*</span></label>
        <input type="text"
               class="form-control"
               name="url_destino"
               id="url_destino"
               value="{{ $urlDestino }}"
               placeholder="Ex: /noticia/minha-noticia ou https://www.sympla.com.br/...">
        <small class="form-text text-muted">
            Aceita URL completa ou caminho interno começando com <code>/</code>.
        </small>
        @error('url_destino')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="fl_nova_aba" value="1" {{ $flNovaAba ? 'checked' : '' }}>
            Abrir em nova aba
        </label>
    </div>
</div>

<script>
(function () {
    function toggleDestinoPanels() {
        var checked = document.querySelector('input[name="tp_destino"]:checked');
        var tipo = checked ? checked.value : 'conteudo';
        var painelConteudo = document.getElementById('painel-conteudo');
        var painelRedirect = document.getElementById('painel-redirect');

        if (!painelConteudo || !painelRedirect) {
            return;
        }

        if (tipo === 'redirect') {
            painelConteudo.classList.add('d-none-destino');
            painelRedirect.classList.remove('d-none-destino');
        } else {
            painelRedirect.classList.add('d-none-destino');
            painelConteudo.classList.remove('d-none-destino');
        }

        document.querySelectorAll('.destino-option').forEach(function (el) {
            el.classList.toggle('is-selected', el.getAttribute('data-destino') === tipo);
        });
    }

    function bindDestinoToggle() {
        document.querySelectorAll('input[name="tp_destino"]').forEach(function (radio) {
            radio.addEventListener('change', toggleDestinoPanels);
            radio.addEventListener('click', toggleDestinoPanels);
        });

        document.querySelectorAll('.destino-option').forEach(function (option) {
            option.addEventListener('click', function () {
                var radio = option.querySelector('input[name="tp_destino"]');
                if (radio) {
                    radio.checked = true;
                    toggleDestinoPanels();
                }
            });
        });

        toggleDestinoPanels();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindDestinoToggle);
    } else {
        bindDestinoToggle();
    }
})();
</script>
