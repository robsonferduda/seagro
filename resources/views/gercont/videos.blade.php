@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-files-o"></i> Boletim</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('boletim/create') }}" class="btn btn-info pull-right ml-3" style="margin-right: 12px;"><i class="fa fa-plus"></i> Cadastrar</a>
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
                            <th>Data de Publicação</th>
                            <th>Título</th>
                            <th class="text-center">Publicado</th>
                            <th class="text-center">Acessos</th>
                            <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data de Publicação</th>
                                <th>Título</th>
                                <th class="text-center">Publicado</th>
                                <th class="text-center">Acessos</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
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

            $(".btn-confirmation").click(function(e) {
                e.preventDefault();

                var url = $(this).attr('href');
                var msg = $(this).data('msg');

                Swal.fire({
                    title: "Tem certeza que deseja realizar essa operação?",
                    html: msg,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, continuar',
                    confirmButtonColor: '#1BC5BD',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then(function(result) {
                    if (result.value) {
                        location = url;
                    }
                });
            });           

        });
    </script>
@endsection