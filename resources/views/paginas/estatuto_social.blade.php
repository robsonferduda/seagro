@extends('layouts.app')
@section('content')
    @php
        $pdfUrl = asset('arquivos/estatuto_social_seagro_sc_2018_27_07_2018.pdf');
        $pdfSrc = $pdfUrl . '#toolbar=1&navpanes=0&scrollbar=1&view=Fit&zoom=page-fit';
    @endphp
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">{{ $pagina->titulo }}</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">
                        <p>
                            Estatuto social do Sindicato dos Engenheiros Agrônomos de Santa Catarina - SEAGRO-SC,
                            reformado em Assembléia Geral Extraordinária, realizada no dia 27 de julho de 2018,
                            em São José/SC, conforme Edital de Convocação publicado no Jornal Diário Catarinense,
                            página 16 da edição de 22 de julho de 2018.
                        </p>

                        <p class="mb-3">
                            <a href="{{ $pdfUrl }}" target="_blank" rel="noopener" download>
                                <i class="fa fa-file-pdf"></i> Clique aqui para baixar o Estatuto Social
                            </a>
                        </p>

                        <div class="estatuto-pdf-viewer" id="estatuto-pdf-viewer">
                            <object data="{{ $pdfSrc }}"
                                    type="application/pdf"
                                    width="100%"
                                    aria-label="Visualização do Estatuto Social">
                                <iframe src="{{ $pdfSrc }}"
                                        title="Estatuto Social SEAGRO-SC"
                                        width="100%"
                                        style="border:0;">
                                </iframe>
                                <p class="mt-3">
                                    Seu navegador não consegue exibir o PDF aqui.
                                    <a href="{{ $pdfUrl }}" target="_blank" rel="noopener">Abra o arquivo</a>
                                    ou
                                    <a href="{{ $pdfUrl }}" download>faça o download</a>.
                                </p>
                            </object>
                        </div>

                        <p class="mt-3">
                            <a href="{{ url('/') }}">Voltar para o Início</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .estatuto-pdf-viewer {
            width: 100%;
            margin: 1rem 0 1.5rem;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .estatuto-pdf-viewer object,
        .estatuto-pdf-viewer iframe {
            display: block;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

    <script>
        (function () {
            var A4_RATIO = 297 / 210;
            var TOOLBAR_OFFSET = 56;

            function adjustEstatutoPdfHeight() {
                var viewer = document.getElementById('estatuto-pdf-viewer');
                if (!viewer) {
                    return;
                }

                var width = viewer.clientWidth || viewer.offsetWidth;
                if (!width) {
                    return;
                }

                var height = Math.round(width * A4_RATIO) + TOOLBAR_OFFSET;
                viewer.style.height = height + 'px';

                var embeds = viewer.querySelectorAll('object, iframe');
                for (var i = 0; i < embeds.length; i++) {
                    embeds[i].setAttribute('height', height);
                    embeds[i].style.height = height + 'px';
                }
            }

            var resizeTimer;
            function onResize() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(adjustEstatutoPdfHeight, 100);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', adjustEstatutoPdfHeight);
            } else {
                adjustEstatutoPdfHeight();
            }

            window.addEventListener('resize', onResize);
            window.addEventListener('orientationchange', function () {
                setTimeout(adjustEstatutoPdfHeight, 200);
            });
        })();
    </script>
@endsection
