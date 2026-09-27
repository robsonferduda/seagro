<style>
.bl-file {
    position: relative;
    display: flex !important;
    align-items: center;
    gap: 0.75rem;
    width: 100%;
    padding: 0.8rem 0.9rem;
    margin-bottom: 0.35rem;
    border: 2px dashed #c5d3e0;
    border-radius: 8px;
    background: #f5f8fb;
    cursor: pointer;
    transition: border-color .15s, background .15s;
}
.bl-file:hover { border-color: #51cbce; background: #f0f9fa; }
.bl-file.selecionado { border-style: solid; border-color: #1aae6f; background: #effaf4; }
.bl-file-input { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
.bl-file-icone {
    flex: 0 0 42px;
    height: 42px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    background: #eef3f8;
    color: #336693;
}
.bl-file-icone.pdf { background: #fdecec; color: #c0392b; }
.bl-file-icone.audio { background: #eef0fd; color: #5b5fc7; }
.bl-file-texto { display: flex; flex-direction: column; min-width: 0; line-height: 1.3; }
.bl-file-texto strong { font-size: 0.85rem; color: #284866; }
.bl-file-nome { font-size: 0.8rem; color: #336693; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.bl-file-texto small { font-size: 0.72rem; color: #6b7c8f; font-weight: 400; }
.bl-file-atual { display: inline-block; font-size: 0.75rem; color: #6b7c8f; margin-bottom: 0.5rem; word-break: break-all; }
.bl-capa-preview {
    width: 100%;
    max-height: 260px;
    object-fit: contain;
    border-radius: 6px;
    background: #fff;
    margin-bottom: 0.5rem;
}
.bl-estat { display: flex; gap: 0.6rem; }
.bl-estat div { flex: 1; text-align: center; background: #f5f8fb; border: 1px solid #e3e8ee; border-radius: 8px; padding: 0.5rem; }
.bl-estat strong { display: block; font-size: 1.2rem; color: #284866; }
.bl-estat span { font-size: 0.7rem; text-transform: uppercase; color: #6b7c8f; }
</style>
