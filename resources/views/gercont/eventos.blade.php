@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="nc-icon nc-tag-content"></i> Eventos</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('evento/create') }}" class="btn btn-info pull-right ml-3" style="margin-right: 12px;"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Data de Criação</th>
                                <th>Título</th>
                                <th>Link</th>
                                <th class="text-center">Última Atualização</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">Data de Criação</th>
                                <th>Título</th>
                                <th>Link</th>
                                <th class="text-center">Última Atualização</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($eventos as $evento)
                               
                            @endforeach
                        </tbody>
                    </table>
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