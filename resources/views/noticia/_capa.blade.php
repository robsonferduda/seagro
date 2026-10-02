@php
    $capaAtual = isset($noticia) && $noticia->img_capa ? $noticia->urlCapa() : null;
@endphp

<style>
.noticia-form .capa-quadro {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 6px;
    background: #1f3548;
    margin-bottom: 0.5rem;
}
@supports not (aspect-ratio: 4 / 3) {
    .noticia-form .capa-quadro { height: 0; padding-top: 75%; }
}
.noticia-form .capa-quadro img {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
}
.noticia-form .capa-quadro.is-contain img { object-fit: contain; }
.noticia-form .capa-fundo {
    position: absolute;
    top: -20px; right: -20px; bottom: -20px; left: -20px;
    background-size: cover;
    background-position: center;
    filter: blur(14px) brightness(0.7);
    display: none;
}
.noticia-form .capa-quadro.is-contain .capa-fundo { display: block; }
.noticia-form .capa-legenda {
    position: absolute;
    left: 0; right: 0; bottom: 0;
    background: #154166;
    color: #fff;
    font-size: 0.68rem;
    font-weight: 700;
    line-height: 1.3;
    padding: 0.35rem 0.5rem;
    text-align: center;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.noticia-form .capa-vazia {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9fb3c8;
    font-size: 0.78rem;
    text-align: center;
    padding: 1rem;
}
.noticia-form .capa-vazia i { font-size: 1.6rem; margin-bottom: 0.35rem; }
.noticia-form .capa-status {
    font-size: 0.76rem;
    border-radius: 6px;
    padding: 0.4rem 0.55rem;
    margin-bottom: 0.5rem;
    text-align: left;
    line-height: 1.35;
}
.noticia-form .capa-status.ok { background: #e3f6ec; color: #1e7a4a; }
.noticia-form .capa-status.aviso { background: #fff4e0; color: #9a5b00; }
.noticia-form .capa-status strong { font-weight: 700; }
.noticia-form .capa-acoes { display: flex; gap: 0.4rem; margin-top: 0.4rem; }
.noticia-form .capa-acoes .btn { margin: 0 !important; flex: 1 1 auto; }
.noticia-form .capa-dica { font-size: 0.72rem; color: var(--nf-muted); text-align: left; margin-top: 0.5rem; line-height: 1.4; }
#modalRecorteCapa .modal-body { background: #f5f8fb; }
#modalRecorteCapa .recorte-area { max-height: 65vh; }
#modalRecorteCapa .recorte-area img { display: block; max-width: 100%; }
</style>

<div class="nf-panel nf-panel-side">
    <div class="nf-panel-title">
        <span>Imagem de capa</span>
        <small class="text-muted text-normal">Prévia do carrossel</small>
    </div>
    <div class="nf-capa-box">
        <div class="capa-quadro" id="capaQuadro">
            <span class="capa-fundo" id="capaFundo" style="{{ $capaAtual ? "background-image:url('" . $capaAtual . "')" : '' }}"></span>
            <img id="preview-image" src="{{ $capaAtual }}" alt="" style="{{ $capaAtual ? '' : 'display:none;' }}">
            <div class="capa-vazia" id="capa-empty" style="{{ $capaAtual ? 'display:none;' : '' }}">
                <i class="fa fa-cloud-upload"></i>
                Recomendado: 1200×900 px (4:3)<br>JPG ou PNG · até 5MB
            </div>
            <div class="capa-legenda" id="capaLegenda">{{ isset($noticia) ? $noticia->titulo : 'Título da notícia' }}</div>
        </div>

        <div class="capa-status d-none" id="capaStatus"></div>

        <div class="custom-file text-left">
            <input type="file" name="img_capa" class="custom-file-input" id="img_capa" accept="image/jpeg,image/png,image/webp">
            <label class="custom-file-label" for="img_capa">{{ $capaAtual ? 'Substituir capa' : 'Selecionar capa' }}</label>
        </div>
        <div class="capa-acoes">
            <button type="button" class="btn btn-sm btn-outline-primary d-none" id="btnRecortarCapa"><i class="fa fa-crop"></i> Recortar 4:3</button>
            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="btnDesfazerRecorte"><i class="fa fa-undo"></i> Usar original</button>
        </div>
        @error('img_capa') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror

        <div class="capa-dica">
            <i class="fa fa-info-circle"></i>
            Use <strong>1200×900 px</strong> (proporção 4:3). Evite textos e logos na parte de baixo: o título da notícia cobre essa faixa no carrossel.
            A imagem é otimizada automaticamente ao salvar.
        </div>
    </div>
</div>

<div class="modal fade" id="modalRecorteCapa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-crop"></i> Recortar capa em 4:3</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-2" style="font-size:0.82rem;">
                    Arraste e redimensione a área para escolher o enquadramento. A faixa inferior escura indica onde o título aparece no carrossel.
                </p>
                <div class="recorte-area">
                    <img id="recorteImagem" src="" alt="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAplicarRecorte"><i class="fa fa-check"></i> Aplicar recorte</button>
            </div>
        </div>
    </div>
</div>
