<style>
.as-secao { background: #f3f6f9; padding: 48px 0 64px; }
.as-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(21, 65, 102, 0.10);
    overflow: hidden;
}
.as-auth { max-width: 940px; margin: 0 auto; display: flex; flex-wrap: wrap; }
.as-auth-lado {
    flex: 1 1 340px;
    background: linear-gradient(160deg, #154166 0%, #336693 100%);
    color: #fff;
    padding: 40px 36px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.as-auth-lado h2 { color: #fff; font-size: 1.6rem; font-weight: 700; margin-bottom: 0.6rem; }
.as-auth-lado p { color: rgba(255, 255, 255, 0.85); font-size: 0.95rem; }
.as-auth-lado ul { list-style: none; padding: 0; margin: 1rem 0 0; }
.as-auth-lado li { display: flex; gap: 0.6rem; align-items: flex-start; margin-bottom: 0.7rem; color: rgba(255, 255, 255, 0.92); font-size: 0.92rem; }
.as-auth-lado li i { color: #8fd3ff; font-size: 1.05rem; line-height: 1.3; }
.as-auth-form { flex: 1 1 380px; padding: 40px 36px; }
.as-auth-form h3 { color: #154166; font-size: 1.35rem; font-weight: 700; margin-bottom: 0.25rem; }
.as-auth-form .as-sub { color: #6b7c8f; font-size: 0.9rem; margin-bottom: 1.4rem; }
.as-form label { font-weight: 600; color: #34495e; font-size: 0.88rem; margin-bottom: 0.3rem; }
.as-form .form-control { border-radius: 8px; padding: 0.6rem 0.8rem; border-color: #d3dce6; }
.as-form .form-control:focus { border-color: #336693; box-shadow: 0 0 0 0.2rem rgba(51, 102, 147, 0.15); }
.as-form .form-control[readonly] { background: #f3f6f9; color: #51657a; }
.as-form .mb-3 small.as-ajuda { color: #8395a7; font-size: 0.78rem; }
.as-senha { position: relative; }
.as-senha .form-control { padding-right: 2.6rem; }
.as-senha button {
    position: absolute; right: 0.4rem; top: 50%; transform: translateY(-50%);
    border: 0; background: transparent; color: #8395a7; padding: 0.25rem 0.45rem;
}
.as-btn {
    background: #336693; border-color: #336693; color: #fff;
    border-radius: 8px; padding: 0.65rem 1rem; font-weight: 600;
}
.as-btn:hover, .as-btn:focus { background: #154166; border-color: #154166; color: #fff; }
.as-links { margin-top: 1.2rem; font-size: 0.88rem; text-align: center; color: #6b7c8f; }
.as-links a { color: #336693; font-weight: 600; text-decoration: none; }
.as-links a:hover { text-decoration: underline; }
.as-sep { border-top: 1px solid #e6ecf2; margin: 1.3rem 0 1rem; }
.as-alerta { border-radius: 8px; font-size: 0.9rem; }

.as-topo {
    background: linear-gradient(120deg, #154166 0%, #336693 100%);
    color: #fff;
    border-radius: 14px;
    padding: 26px 30px;
    margin-bottom: 1.5rem;
    display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
}
.as-topo h2 { color: #fff; font-size: 1.5rem; font-weight: 700; margin: 0; }
.as-topo p { color: rgba(255, 255, 255, 0.85); margin: 0.2rem 0 0; font-size: 0.92rem; }
.as-nav { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.as-nav a, .as-nav button {
    color: #fff; background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 20px; padding: 0.4rem 0.95rem; font-size: 0.86rem; font-weight: 600; text-decoration: none;
}
.as-nav a:hover, .as-nav button:hover { background: rgba(255, 255, 255, 0.22); color: #fff; }
.as-nav a.ativo { background: #fff; color: #154166; border-color: #fff; }

.as-bloco { padding: 24px 26px; margin-bottom: 1.5rem; }
.as-bloco-titulo {
    display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
    color: #154166; font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem;
}
.as-bloco-titulo a { font-size: 0.85rem; font-weight: 600; color: #336693; text-decoration: none; }
.as-dado { display: flex; gap: 0.75rem; padding: 0.55rem 0; border-bottom: 1px dashed #e6ecf2; font-size: 0.92rem; }
.as-dado:last-child { border-bottom: 0; }
.as-dado span { flex: 0 0 70px; color: #8395a7; }
.as-dado strong { color: #2c3e50; word-break: break-word; font-weight: 600; }

.as-etapas { list-style: none; padding: 0; margin: 0; }
.as-etapa { display: flex; gap: 0.9rem; position: relative; padding-bottom: 1.15rem; }
.as-etapa:last-child { padding-bottom: 0; }
.as-etapa:not(:last-child)::before {
    content: ''; position: absolute; left: 17px; top: 36px; bottom: 0; width: 2px; background: #e3e9f0;
}
.as-etapa-num {
    flex: 0 0 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: #eef3f8; color: #8395a7; font-weight: 700; font-size: 0.9rem;
}
.as-etapa.ok .as-etapa-num { background: #1aae6f; color: #fff; }
.as-etapa h4 { font-size: 0.97rem; font-weight: 700; color: #2c3e50; margin: 0.4rem 0 0.15rem; }
.as-etapa p { font-size: 0.85rem; color: #6b7c8f; margin: 0; }
.as-etapa .badge { font-size: 0.68rem; vertical-align: middle; margin-left: 0.35rem; }

.as-docs { list-style: none; padding: 0; margin: 0; }
.as-docs li + li { border-top: 1px solid #eef2f6; }
.as-docs a { display: flex; gap: 0.75rem; align-items: center; padding: 0.65rem 0; text-decoration: none; color: #2c3e50; }
.as-docs a:hover strong { color: #336693; }
.as-docs i { font-size: 1.35rem; color: #c0392b; }
.as-docs strong { display: block; font-size: 0.9rem; font-weight: 600; }
.as-docs small { color: #8395a7; font-size: 0.78rem; }

@media (max-width: 575px) {
    .as-auth-lado, .as-auth-form { padding: 28px 22px; }
    .as-topo { padding: 22px; }
}
</style>
