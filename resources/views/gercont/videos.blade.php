@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-video-camera ml-3"></i> Vídeos</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('video/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="col-md-12">
                <div class="alert alert-info alert-with-icon" data-notify="container">
                    <span data-notify="icon" class="fa fa-exclamation-triangle"></span>
                    <span data-notify="message">Utilize o campo <strong>Publicado</strong> para controlar a visualização de vídeos na página inicial.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Data de Publicação</th>
                                <th>Título</th>
                                <th>URL</th>
                                <th class="text-center">Publicado</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data de Publicação</th>
                                <th>Título</th>
                                <th>URL</th>
                                <th class="text-center">Publicado</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($video->dt_video)) }}</td>
                                    <td>{{ $video->nm_video }}</td>
                                    <td>{{ $video->url }}</td>
                                    <td class="text-center">
                                        @if($video->fl_ativo)
                                            <a href="{{ url('videos/publicacao/atualizar', $video->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja ocultar este vídeo?"><span class="badge badge-success">SIM</span></a>
                                        @else
                                            <a href="{{ url('videos/publicacao/atualizar', $video->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja publicar este vídeo?"><span class="badge badge-danger">NÃO</span></a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a title="Detalhes" href="{{ url('video', $video->id) }}" class="btn btn-warning btn-link btn-icon"><i class="fa fa-files-o fa-2x"></i></a>
                                        <a title="Editar" href="{{ route('video.edit',$video) }}" class="btn btn-primary btn-link btn-icon"><i class="fa fa-edit fa-2x"></i></a>
                                        <a title="Excluir" href="{{ url('video/'.$video->id.'/delete') }}" class="btn btn-danger btn-link btn-icon btn-confirmation" data-msg="Deseja excluir o vídeo selecionado?"><i class="fa fa-times fa-2x"></i></a>
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