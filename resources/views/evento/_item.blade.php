@php
    $dataEvento = \Carbon\Carbon::parse($evento->data);
    $tipoNome = optional($evento->tipo)->nm_tipo;
    if (!$tipoNome) {
        $tipoNome = $evento->id_tipo == 1 ? 'Presencial' : ($evento->id_tipo == 2 ? 'Online' : 'Híbrido');
    }
    $tipoClass = 'evento-tipo-' . \Illuminate\Support\Str::slug($tipoNome);
    $link = $evento->linkPublico();
    $target = $evento->abreNovaAba() ? '_blank' : '_self';
    $rel = $evento->abreNovaAba() ? 'noopener' : null;
@endphp
<a href="{{ $link }}"
   class="evento-item {{ $tipoClass }}"
   @if($target === '_blank') target="_blank" rel="noopener" @endif>
    <div class="evento-item-date">
        <span class="evento-item-day">{{ $dataEvento->format('d') }}</span>
        <span class="evento-item-month">{{ App\Models\Utils::formataMes($dataEvento->format('m')) }}</span>
        <span class="evento-item-year">{{ $dataEvento->format('Y') }}</span>
    </div>
    <div class="evento-item-body">
        <div class="evento-item-meta">
            <span class="evento-item-badge">{{ mb_strtoupper($tipoNome, 'UTF-8') }}</span>
            <span class="evento-item-full-date">{{ $dataEvento->format('d/m/Y') }}</span>
            @if($evento->isRedirect())
                <span class="evento-item-badge evento-badge-redirect">REDIRECT</span>
            @endif
        </div>
        <h3 class="evento-item-title">{{ $evento->titulo }}</h3>
        @if(!empty($showExcerpt) && !$evento->isRedirect() && !empty($evento->descricao))
            <p class="evento-item-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($evento->descricao), 140) }}</p>
        @endif
    </div>
    <div class="evento-item-action" aria-hidden="true">
        <i class="fa {{ $evento->isRedirect() ? 'fa-external-link' : 'fa-angle-right' }}"></i>
    </div>
</a>
