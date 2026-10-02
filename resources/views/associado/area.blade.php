@extends('layouts.app')
@section('content')
@include('associado._estilo')
<section class="as-secao">
    <div class="container">
        @include('associado._topo')
        @include('associado._alertas')

        <div class="row">
            <div class="col-lg-7">
                <div class="as-card as-bloco">
                    <div class="as-bloco-titulo"><span><i class="bi bi-signpost-split"></i> Proposta de associação</span></div>
                    <ol class="as-etapas">
                        <li class="as-etapa ok">
                            <div class="as-etapa-num"><i class="bi bi-check-lg"></i></div>
                            <div>
                                <h4>Cadastro no site</h4>
                                <p>Concluído em {{ $associado->created_at ? $associado->created_at->format('d/m/Y') : '-' }}.</p>
                            </div>
                        </li>
                        <li class="as-etapa">
                            <div class="as-etapa-num">2</div>
                            <div>
                                <h4>Preencher os dados da proposta <span class="badge bg-secondary">Em breve</span></h4>
                                <p>Formulário com seus dados pessoais e profissionais.</p>
                            </div>
                        </li>
                        <li class="as-etapa">
                            <div class="as-etapa-num">3</div>
                            <div>
                                <h4>Gerar e assinar o documento <span class="badge bg-secondary">Em breve</span></h4>
                                <p>A proposta será gerada já preenchida para você baixar e assinar.</p>
                            </div>
                        </li>
                        <li class="as-etapa">
                            <div class="as-etapa-num">4</div>
                            <div>
                                <h4>Enviar a proposta assinada <span class="badge bg-secondary">Em breve</span></h4>
                                <p>Envio do documento assinado diretamente por aqui.</p>
                            </div>
                        </li>
                    </ol>
                </div>

                @if($documentos->count())
                    <div class="as-card as-bloco">
                        <div class="as-bloco-titulo">
                            <span><i class="bi bi-file-earmark-text"></i> Documentos para associação</span>
                            <a href="{{ url('pagina/fique-socio') }}">Página Fique sócio <i class="bi bi-arrow-right"></i></a>
                        </div>
                        <ul class="as-docs">
                            @foreach($documentos as $documento)
                                <li>
                                    <a href="{{ $documento->urlPublica() }}" target="_blank" rel="noopener">
                                        <i class="bi {{ $documento->extensao() === 'pdf' ? 'bi-file-earmark-pdf' : 'bi-file-earmark' }}"></i>
                                        <span>
                                            <strong>{{ $documento->titulo }}</strong>
                                            @if($documento->subtitulo)<small>{{ $documento->subtitulo }}</small>@endif
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="as-card as-bloco">
                        <div class="as-bloco-titulo"><span><i class="bi bi-file-earmark-text"></i> Documentos para associação</span></div>
                        <p class="mb-3" style="font-size:0.9rem;color:#51657a;">
                            Enquanto o preenchimento on-line não fica pronto, os formulários de proposta de novo sócio estão disponíveis na página Fique sócio.
                        </p>
                        <a href="{{ url('pagina/fique-socio') }}" class="btn as-btn"><i class="bi bi-box-arrow-up-right"></i> Ver formulários</a>
                    </div>
                @endif
            </div>

            <div class="col-lg-5">
                <div class="as-card as-bloco">
                    <div class="as-bloco-titulo">
                        <span><i class="bi bi-person-vcard"></i> Seus dados</span>
                        <a href="{{ route('associado.dados') }}"><i class="bi bi-pencil"></i> Editar</a>
                    </div>
                    <div class="as-dado"><span>Nome</span><strong>{{ $associado->nome }}</strong></div>
                    <div class="as-dado"><span>CPF</span><strong>{{ $associado->cpfFormatado() }}</strong></div>
                    <div class="as-dado"><span>E-mail</span><strong>{{ $associado->email }}</strong></div>
                </div>

                <div class="as-card as-bloco">
                    <div class="as-bloco-titulo"><span><i class="bi bi-headset"></i> Precisa de ajuda?</span></div>
                    <p class="mb-2" style="font-size:0.9rem;color:#51657a;">Fale com a secretaria do SEAGRO-SC:</p>
                    <div class="as-dado"><span>E-mail</span><strong><a href="mailto:seagro@seagro-sc.org.br">seagro@seagro-sc.org.br</a></strong></div>
                    <div class="as-dado"><span>Telefone</span><strong>(48) 3224-5681</strong></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
