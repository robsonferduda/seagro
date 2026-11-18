@php
    $tipo = $menu->tipoDestino();
    $urlExibir = $menu->url ?: ($menu->pagina ? 'pagina/' . $menu->pagina->apelido : null);
@endphp
<tr class="{{ $menu->fl_ativo ? '' : 'table-secondary' }}">
    <td class="text-center">{{ $menu->ordem }}</td>
    <td>
        @if($nivel > 0)
            <span class="mn-indent">{{ str_repeat('— ', $nivel) }}</span>
        @endif
        <span class="mn-nome">{{ $menu->descricao }}</span>
        @if($menu->apelido)
            <br><small class="text-muted">{{ $menu->apelido }}</small>
        @endif
    </td>
    <td class="mn-destino">
        @if($tipo === 'pagina')
            <span class="badge badge-info">Página</span>
            @if($menu->pagina)
                <a href="{{ url('pagina-admin/' . $menu->pagina->id . '/edit') }}" title="Editar página">{{ $menu->pagina->titulo }}</a>
            @endif
            @if($urlExibir)
                <br><small class="text-muted"><i class="fa fa-link"></i> {{ $urlExibir }}</small>
            @endif
        @elseif($tipo === 'link')
            <span class="badge badge-primary">Link</span>
            <a href="{{ $menu->urlPublica() }}" target="_blank" rel="noopener">{{ $urlExibir }}</a>
        @else
            <span class="badge badge-secondary">Agrupador</span>
            <small class="text-muted d-block">Sem URL — apenas abre submenus</small>
        @endif
    </td>
    <td class="text-center">
        @if($menu->fl_ativo)
            <span class="badge badge-success">Ativo</span>
        @else
            <span class="badge badge-secondary">Inativo</span>
        @endif
    </td>
    <td class="text-center mn-acoes">
        <a href="{{ url('menu-admin/' . $menu->id . '/edit') }}" class="btn btn-sm btn-info" title="Editar"><i class="fa fa-pencil"></i></a>
        <a href="{{ url('menu-admin/' . $menu->id . '/toggle-ativo') }}"
           class="btn btn-sm {{ $menu->fl_ativo ? 'btn-warning' : 'btn-success' }}"
           title="{{ $menu->fl_ativo ? 'Desativar' : 'Ativar' }}">
            <i class="fa {{ $menu->fl_ativo ? 'fa-eye-slash' : 'fa-check' }}"></i>
        </a>
        <form method="POST" action="{{ url('menu-admin/' . $menu->id . '/destroy') }}"
              onsubmit="return confirm('Excluir o menu {{ addslashes($menu->descricao) }}?');">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger" title="Excluir"><i class="fa fa-trash"></i></button>
        </form>
    </td>
</tr>
