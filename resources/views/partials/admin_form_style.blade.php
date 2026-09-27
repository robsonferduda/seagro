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
</style>
