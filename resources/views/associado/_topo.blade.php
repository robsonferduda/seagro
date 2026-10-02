<div class="as-topo">
    <div>
        <h2>Olá, {{ $associado->primeiroNome() }}!</h2>
        <p>Área do Associado SEAGRO-SC</p>
    </div>
    <nav class="as-nav">
        <a href="{{ route('associado.area') }}" class="{{ request()->routeIs('associado.area') ? 'ativo' : '' }}"><i class="bi bi-house"></i> Início</a>
        <a href="{{ route('associado.dados') }}" class="{{ request()->routeIs('associado.dados') ? 'ativo' : '' }}"><i class="bi bi-person"></i> Meus dados</a>
        <form method="POST" action="{{ route('associado.logout') }}" class="d-inline">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-right"></i> Sair</button>
        </form>
    </nav>
</div>
