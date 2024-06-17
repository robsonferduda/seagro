@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Empresas Públicas - {{ $pagina }}</h2>
                </div>
                <div class="row">
                    <style type="text/css">
                   
            
                        .white-bg {
                            background-color: #ffffff;
                        }
                        .page-heading {
                            border-top: 0;
                            padding: 0 10px 20px 10px;
                        }
                
                        .forum-post-container .media {
                            margin: 10px 10px 10px 10px;
                            padding: 20px 10px 20px 10px;
                            border-bottom: 1px solid #f1f1f1;
                        }
                        .forum-avatar {
                            float: left;
                            margin-right: 20px;
                            text-align: center;
                            width: 110px;
                        }
                        .forum-avatar .img-circle {
                            height: 48px;
                            width: 48px;
                        }
                        .author-info {
                            color: #676a6c;
                            font-size: 11px;
                            margin-top: 5px;
                            text-align: center;
                        }
                        .forum-post-info {
                            padding: 9px 12px 6px 12px;
                            background: #f9f9f9;
                            border: 1px solid #f1f1f1;
                        }
                        .media-body > .media {
                            background: #f9f9f9;
                            border-radius: 3px;
                            border: 1px solid #f1f1f1;
                        }
                        .forum-post-container .media-body .photos {
                            margin: 10px 0;
                        }
                        .forum-photo {
                            max-width: 140px;
                            border-radius: 3px;
                        }
                        .media-body > .media .forum-avatar {
                            width: 70px;
                            margin-right: 10px;
                        }
                        .media-body > .media .forum-avatar .img-circle {
                            height: 38px;
                            width: 38px;
                        }
                        .mid-icon {
                            font-size: 66px;
                        }
                        .forum-item {
                            margin: 10px 0;
                            padding: 10px 0 20px;
                            border-bottom: 1px solid #f1f1f1;
                        }
                        .views-number {
                            font-size: 18px;
                            line-height: 18px;
                            font-weight: 400;
                        }
                        .forum-container,
                        .forum-post-container {
                            
                            color:#284866!important;
                            min-height: 600px;
                        }
                        .forum-item small {
                            color: #999;
                        }
                        .forum-item .forum-sub-title {
                            color: #999;
                            margin-left: 50px;
                        }
                        .forum-title {
                            margin: 15px 0 15px 0;
                        }
                        .forum-info {
                            text-align: center;
                        }
                        .forum-desc {
                            color: #999;
                        }
                        .forum-icon {
                            float: left;
                            width: 30px;
                            margin-right: 20px;
                            text-align: center;
                        }
                        a.forum-item-title {
                            color: inherit;
                            display: block;
                            font-size: 18px;
                            font-weight: 600;
                        }
                        a.forum-item-title:hover {
                            color: inherit;
                        }
                        .forum-icon .fa {
                            font-size: 30px;
                            margin-top: 8px;
                            color: #9b9b9b;
                        }
                        .forum-item.active .fa {
                            color: #1ab394;
                        }
                        .forum-item.active a.forum-item-title {
                            color: #1ab394;
                        }
                        @media (max-width: 992px) {
                            .forum-info {
                                margin: 15px 0 10px 0;
                                /* Comment this is you want to show forum info in small devices */
                                display: none;
                            }
                            .forum-desc {
                                float: none !important;
                            }
                        }
                    </style>
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">

                        @if($pagina == 'Pautas de Reivindicações')
                        <div class="ibox-content forum-container">
                            <div class="forum-item">
                               <div class="row">
                                 <div class="col-md-10" style="text-align: left;">
                                     <div class="forum-icon">
                                        <i class="fa fa-bookmark"></i>
                                     </div>
                                     <a href="https://www.seagro-sc.org.br/campanha-salarial/empresas-publicas/pauta_de_reivindicacoes_2024_2025_ceasa.pdf" class="forum-item-title">Pauta de Reivindicações 2023/2024 - CEASA</a>
                                     <div class="forum-sub-title"></div>
                                 </div>
                                 <div class="col-md-2 forum-info">
                                     <div>
                                        <small>Publicado em</small>
                                     </div>
                                     <span class="views-number">
                                        17/06/2024
                                     </span>
                                 </div>
                               </div>
                            </div>
                            <div class="forum-item">
                               <div class="row">
                                 <div class="col-md-10" style="text-align: left;">
                                     <div class="forum-icon">
                                        <i class="fa fa-bookmark"></i>
                                     </div>
                                     <a href="https://www.seagro-sc.org.br/campanha-salarial/empresas-publicas/pauta_de_reivindicacoes_2024_2025_cidasc.pdf" class="forum-item-title">Pauta de Reivindicações 2023/2024 - CIDASC</a>
                                     <div class="forum-sub-title"></div>
                                 </div>
                                 <div class="col-md-2 forum-info">
                                     <div>
                                        <small>Publicado em</small>
                                     </div>
                                     <span class="views-number">
                                        17/06/2024
                                     </span>
                                 </div>
                               </div>
                            </div>
                            <div class="forum-item">
                               <div class="row">
                                 <div class="col-md-10" style="text-align: left;">
                                     <div class="forum-icon">
                                        <i class="fa fa-bookmark"></i>
                                     </div>
                                     <a href="https://www.seagro-sc.org.br/campanha-salarial/empresas-publicas/pauta_de_reivindicacoes_2024_2025_epagri.pdf" class="forum-item-title">Pauta de Reivindicações 2023/2024 - EPAGRI</a>
                                     <div class="forum-sub-title"></div>
                                 </div>
                                 <div class="col-md-2 forum-info">
                                     <div>
                                        <small>Publicado em</small>
                                     </div>
                                     <span class="views-number">
                                        17/06/2024
                                     </span>
                                 </div>
                               </div>
                            </div>
                        </div>
                        @endif                        
                        <a href="{{ URL::previous() }}">Voltar para o Início</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection