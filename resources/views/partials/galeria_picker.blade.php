{{-- Modal + estilos do seletor da Galeria (incluir no content) --}}
<div class="modal fade" id="modalGaleriaPicker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content galeria-picker-modal">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-picture-o"></i> Inserir da Galeria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="galeria-picker-busca">
                    <input type="search" id="galeriaPickerBusca" placeholder="Buscar imagem..." autocomplete="off">
                    <button type="button" class="btn btn-primary btn-sm" id="galeriaPickerBuscar"><i class="fa fa-search"></i></button>
                    <a href="{{ url('galeria/create') }}" target="_blank" class="btn btn-info btn-sm" title="Enviar novas imagens">
                        <i class="fa fa-upload"></i> Upload
                    </a>
                </div>
                <div id="galeriaPickerGrid" class="galeria-picker-grid">
                    <div class="galeria-picker-loading text-muted text-center py-4">
                        <i class="fa fa-spinner fa-spin"></i> Carregando...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <small class="text-muted mr-auto">Clique em uma imagem para inserir no texto.</small>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style>
.galeria-picker-modal .modal-header {
    background: #284866;
    color: #fff;
    border-bottom: 0;
}
.galeria-picker-modal .modal-header .close { color: #fff; opacity: .85; }
.galeria-picker-modal .modal-title { font-weight: 600; }
.galeria-picker-busca {
    display: flex;
    gap: 0.4rem;
    margin-bottom: 1rem;
}
.galeria-picker-busca input {
    flex: 1;
    height: 36px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0 0.75rem;
    font-size: 0.875rem;
}
.galeria-picker-busca .btn { margin: 0 !important; height: 36px; }
.galeria-picker-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 0.65rem;
    max-height: 420px;
    overflow-y: auto;
}
.galeria-picker-item {
    border: 2px solid #e3e8ee;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    background: #f5f8fb;
    transition: border-color .15s, transform .15s;
}
.galeria-picker-item:hover {
    border-color: #51cbce;
    transform: translateY(-2px);
}
.galeria-picker-item img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    display: block;
}
.galeria-picker-item span {
    display: block;
    padding: 0.35rem 0.4rem;
    font-size: 0.68rem;
    color: #51657a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.note-editor.note-frame {
    border: 1px solid #d7dee8 !important;
    border-radius: 8px;
    /* NÃO usar overflow:hidden — corta os dropdowns da toolbar (fonte, estilo, cor) */
    overflow: visible;
}
.note-editor .note-toolbar {
    background: #f5f8fb !important;
    border-bottom: 1px solid #e3e8ee !important;
    overflow: visible !important;
    position: relative;
    z-index: 30;
}
.note-editor .note-editing-area {
    overflow: hidden;
    position: relative;
    z-index: 1;
}
</style>
