<style>
.noticia-form {
    --nf-navy: #284866;
    --nf-muted: #6b7c8f;
    --nf-border: #e3e8ee;
    --nf-bg: #f5f8fb;
}
.noticia-form .nf-hero {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.25rem;
    padding: 1.1rem 1.25rem;
    background: linear-gradient(135deg, #284866 0%, #336693 100%);
    border-radius: 10px;
    color: #fff;
}
.noticia-form .nf-hero h3 {
    margin: 0 0 0.2rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
}
.noticia-form .nf-hero p { margin: 0; opacity: 0.85; font-size: 0.9rem; }
.noticia-form .nf-hero .btn { margin: 0 !important; }
.noticia-form .nf-panel {
    background: #fff;
    border: 1px solid var(--nf-border);
    border-radius: 10px;
    padding: 1.15rem 1.25rem;
    margin-bottom: 1rem;
}
.noticia-form .nf-panel-side { padding: 0.9rem 1rem; margin-bottom: 0.85rem; }
.noticia-form .nf-panel-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--nf-muted);
    font-weight: 700;
    margin-bottom: 0.75rem;
    padding-bottom: 0.4rem;
    border-bottom: 1px solid var(--nf-border);
}
.noticia-form label { font-weight: 600; color: var(--nf-navy); font-size: 0.85rem; }
.noticia-form .form-control { border-radius: 6px; border-color: #d7dee8; }
.noticia-form .form-control:focus { border-color: #51cbce; box-shadow: none; }
.noticia-form .nf-titulo { font-size: 1.15rem; font-weight: 600; padding: 0.7rem 0.9rem; height: auto; }
.noticia-form .nf-switch {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding: 0.5rem 0.65rem;
    background: var(--nf-bg);
    border: 1px solid var(--nf-border);
    border-radius: 8px;
    margin-bottom: 0.45rem;
}
.noticia-form .nf-switch span { font-size: 0.82rem; color: var(--nf-navy); font-weight: 600; }
.noticia-form .nf-switch small { display: block; font-weight: 400; color: var(--nf-muted); font-size: 0.7rem; }
.noticia-form .nf-info { font-size: 0.82rem; color: var(--nf-muted); margin-bottom: 0.35rem; }
.noticia-form .nf-info strong { color: var(--nf-navy); }
.noticia-form .nf-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: flex-end;
    margin-top: 0.25rem;
    padding: 0.85rem 0 0;
    border-top: 1px solid var(--nf-border);
}
.noticia-form .nf-actions .btn { margin: 0 !important; }
.noticia-form .custom-file-label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.noticia-form .nf-capa-box {
    border: 2px dashed #c5d3e0;
    border-radius: 8px;
    padding: 0.65rem;
    text-align: center;
    background: var(--nf-bg);
    transition: border-color .15s;
}
.noticia-form .nf-capa-box:hover { border-color: #51cbce; }
.noticia-form .nf-capa-empty { padding: 0.55rem 0.25rem; color: var(--nf-muted); font-size: 0.78rem; }
.noticia-form .nf-capa-empty i { font-size: 1.35rem; display: block; margin-bottom: 0.25rem; }
.noticia-form .nf-hint { margin-top: 0.85rem; font-size: 0.78rem; color: var(--nf-muted); }
.noticia-form .text-normal { text-transform: none; letter-spacing: 0; font-weight: 400; }
.noticia-form .nf-file {
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
.noticia-form .nf-file:hover { border-color: #51cbce; background: #f0f9fa; }
.noticia-form .nf-file.selecionado { border-style: solid; border-color: #1aae6f; background: #effaf4; }
.noticia-form .nf-file-input { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
.noticia-form .nf-file-icone {
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
.noticia-form .nf-file-icone.pdf { background: #fdecec; color: #c0392b; }
.noticia-form .nf-file-icone.audio { background: #eef0fd; color: #5b5fc7; }
.noticia-form .nf-file-texto { display: flex; flex-direction: column; min-width: 0; line-height: 1.3; }
.noticia-form .nf-file-texto strong { font-size: 0.85rem; color: #284866; }
.noticia-form .nf-file-nome { font-size: 0.8rem; color: #336693; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.noticia-form .nf-file-texto small { font-size: 0.72rem; color: #6b7c8f; font-weight: 400; }
.noticia-form .nf-file-atual { display: inline-block; font-size: 0.75rem; color: #6b7c8f; margin-bottom: 0.5rem; word-break: break-all; }
</style>
