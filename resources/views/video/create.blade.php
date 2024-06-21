@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-video-camera ml-3"></i> Vídeo > Cadastrar</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/videos') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-video-camera"></i> Vídeos</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <form class="form-horizontal" method="POST" action="{{ url('video') }}">
                        @csrf
                        <div class="form-group m-3 w-70">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data do Vídeo <span class="text-danger">Obrigatório</span></label>
                                        <input type="text" class="form-control data" name="dt_video" id="dt_video" placeholder="__/__/____">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Nome <span class="text-danger">Obrigatório</span></label>
                                        <input type="text" class="form-control" name="nm_video" id="nm_video" placeholder="Nome do Vídeo">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Endereço <span class="text-danger">Obrigatório</span></label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="URL">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check mt-4">
                                            <label class="form-check-label mt-2">
                                                <input class="form-check-input" type="checkbox" name="fl_ativo" value="true">
                                                    ATIVO
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="text-center ml-2 mr-2">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
                            <a href="{{ url()->previous() }}" class="btn btn-danger ml-2"><i class="fa fa-times"></i> Cancelar</a>
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