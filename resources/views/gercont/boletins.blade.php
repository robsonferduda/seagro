@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-files-o ml-3"></i> Boletins</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('boletim/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
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
                            @foreach($boletins as $boletim)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($boletim->dt_publicacao)) }}</td>
                                    <td>{{ $boletim->titulo }}</td>
                                    <td class="text-center">
                                        @if($boletim->fl_publicacao)
                                            <a href="{{ url('boletim/publicacao/atualizar', $boletim->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja ocultar a publicação deste boletim?"><span class="badge badge-success">SIM</span></a>
                                        @else
                                            <a href="{{ url('boletim/publicacao/atualizar', $boletim->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja publicar este boletim?"><span class="badge badge-danger">NÃO</span></a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $boletim->acessos }}</td>
                                    <td class="text-center">
                                        <a title="Detalhes" href="{{ url('boletim', $boletim->id) }}" class="btn btn-warning btn-link btn-icon"><i class="fa fa-files-o fa-2x"></i></a>
                                        <a title="Editar" href="{{ route('boletim.edit',$boletim) }}" class="btn btn-primary btn-link btn-icon"><i class="fa fa-edit fa-2x"></i></a>
                                        <a title="Excluir" href="#" class="btn btn-danger btn-link btn-icon remove"><i class="fa fa-times fa-2x"></i></a>
                                    </td>
                                </tr>
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