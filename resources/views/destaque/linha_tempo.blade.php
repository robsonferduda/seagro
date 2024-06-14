@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Linha do Tempo - Campanha Salarial</h2>
                    <p></p>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">
                        <ul class="timeline">
                            <li>
                                <a target="_blank" href="{{ asset('linha_tempo/linha_tempo_2023-2024.pdf') }}">Campanha Salarial 2023/2024</a>
                                <p>Acompanhamento das ações da Campanha Salarial 2023/2024 das empresas públicas Epagri – Cidasc - Ceasa</p>
                            </li>
                            <li>
                                <a target="_blank" href="{{ asset('linha_tempo/linha_tempo_2022-2023.pdf') }}">Campanha Salarial 2022/2023</a>
                                <p>Acompanhamento das ações da Campanha Salarial 2022/2023 das empresas públicas Epagri – Cidasc - Ceasa</p>
                            </li>
                            <li>
                                <a target="_blank" href="{{ asset('linha_tempo/linha_tempo_2021-2022.pdf') }}">Campanha Salarial 2021/2022</a>
                                <p>Acompanhamento das ações da Campanha Salarial 2021/2022 das empresas públicas Epagri – Cidasc - Ceasa</p>
                            </li>
                            <li>
                                <a target="_blank" href="{{ asset('linha_tempo/linha_tempo_2020-2021.pdf') }}">Campanha Salarial 2020/2021</a>
                                <p>Acompanhamento das ações da Campanha Salarial 2020/2021 das empresas públicas Epagri – Cidasc - Ceasa</p>
                            </li>
                            <li>
                                <a target="_blank" href="{{ asset('linha_tempo/linha_tempo_2019-2020.pdf') }}">Campanha Salarial 2019/2020</a>
                                <p>Acompanhamento das ações da Campanha Salarial 2019/2020 das empresas públicas – Epagri, Cidasc e Ceasa</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection