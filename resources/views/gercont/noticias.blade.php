@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-newspaper-o"></i> Notícias</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('noticia-admin/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
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
                                <th>Data</th>
                                <th>Título</th>
                                <th class="text-center">Publicado</th>
                                <th class="text-center">Acessos</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Título</th>
                                <th class="text-center">Publicado</th>
                                <th class="text-center">Acessos</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($noticias as $noticia)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($noticia->dt_noticia)->format('d/m/Y') }}</td>
                                    <td>{{ $noticia->titulo }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('noticia-admin/' . $noticia->id . '/toggle-ativa') }}" title="{{ $noticia->fl_ativa ? 'Clique para despublicar' : 'Clique para publicar' }}">
                                            @if($noticia->fl_ativa)
                                                <span class="badge badge-success">Sim</span>
                                            @else
                                                <span class="badge badge-danger">Não</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $noticia->num_visitas ?? 0 }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('noticia/' . $noticia->url) }}" target="_blank" class="btn btn-sm btn-default" title="Ver no site"><i class="fa fa-eye"></i></a>
                                        <a href="{{ url('noticia-admin/' . $noticia->id . '/edit') }}" class="btn btn-sm btn-info" title="Editar"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger btn-excluir" data-id="{{ $noticia->id }}" data-titulo="{{ $noticia->titulo }}" title="Excluir"><i class="fa fa-trash"></i></button>
                                        <form id="form-excluir-{{ $noticia->id }}" action="{{ url('noticia-admin/' . $noticia->id . '/destroy') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
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
            $('#datatable').DataTable({
                order: [[0, 'desc']],
                columnDefs: [{ orderable: false, targets: 4 }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json'
                }
            });

            $(document).on('click', '.btn-excluir', function() {
                var id = $(this).data('id');
                var titulo = $(this).data('titulo');
                Swal.fire({
                    title: 'Confirmar exclusão',
                    html: 'Deseja excluir a notícia:<br><strong>' + titulo + '</strong>?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, excluir',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#form-excluir-' + id).submit();
                    }
                });
            });
        });
    </script>
@endsection