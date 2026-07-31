@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2 class="title">Atualização de Cadastro</h2>
                    <p>Preencha os dados abaixo para enviar a solicitação diretamente ao setor de cadastro.</p>
                </div>

                <div class="row">
                    <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
                        <form action="{{ url('email/atualizacao-cadastro') }}" method="post" role="form" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 form-group">
                                    <label>Nome</label>
                                    <input type="text" name="nome" class="form-control" id="nome" value="{{ old('nome') }}" placeholder="Nome" required>
                                </div>
                                <div class="col-lg-6 form-group mt-3 mt-lg-0">
                                    <label>Telefone/Celular</label>
                                    <input type="text" class="form-control" name="celular" id="celular" value="{{ old('celular') }}" placeholder="(99) 99999-9999" required>
                                </div>
                                <div class="col-lg-6 form-group mt-3 mt-lg-0">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="E-mail" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12 form-group">
                                    <label>Endereço Completo</label>
                                    <input type="text" class="form-control" name="endereco" id="endereco" value="{{ old('endereco') }}" placeholder="Endereço completo" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6 form-group">
                                    <label>Empresa</label>
                                    <input type="text" class="form-control" name="empresa" id="empresa" value="{{ old('empresa') }}" placeholder="Empresa" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Local de Trabalho</label>
                                    <input type="text" class="form-control" name="local_trabalho" id="local_trabalho" value="{{ old('local_trabalho') }}" placeholder="Local de trabalho" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group">
                                    <label>Informações Complementares</label>
                                    <textarea class="form-control" name="informacoes_complementares" rows="5" placeholder="Informações complementares">{{ old('informacoes_complementares') }}</textarea>
                                </div>
                            </div>

                            <div class="my-3">
                                <div class="loading">Carregando</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Sua solicitação foi enviada com sucesso.</div>
                            </div>

                            <div class="text-center"><button type="submit">Enviar</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection