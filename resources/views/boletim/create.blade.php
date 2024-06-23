@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="fa fa-files-o ml-3"></i> Boletim
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Novo 
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/boletins') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-files-o"></i> Boletins</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ url('boletim/novo') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group px-3 w-100">
                            <div class="row">
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group">
                                        <label>Data de Publicação</label>
                                        <input type="text" class="form-control datepicker" name="dt_publicacao" required="true" value="{{ date("d/m/Y") }}" placeholder="__/__/____">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3" placeholder="Título" value="{{ old('titulo') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="pdf">Arquivo PDF</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="pdf" class="custom-file-input" id="pdf" value="{{ old('pdf') }}"//>
                                            <label class="custom-file-label" for="arquivo">Selecionar Arquivo</label>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-4">
                                    <label for="imagem">Arquivo Imagem</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="imagem" class="custom-file-input" id="imagem" value="{{ old('imagem') }}"/>
                                            <label class="custom-file-label" for="arquivo">Selecionar Arquivo</label>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <label for="audio">Arquivo Áudio</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="audio" class="custom-file-input" id="audio" value="{{ old('audio') }}"//>
                                            <label class="custom-file-label" for="arquivo">Selecionar Arquivo</label>
                                        </div>
                                    </div>
                                </div>                      
                            </div>     
                            <div class="text-center mb-2 mt-3">
                                <button type="submit" class="btn btn-success" value="salvar"><i class="fa fa-save"></i> Salvar</button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
@section('script')    
    <script>
        $(document).ready(function(){
             
        });
    </script>
@endsection