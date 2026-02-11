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
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('evento/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
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
                                <th>Data do Evento</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th class="text-center">Ativo</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data do Evento</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th class="text-center">Ativo</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($eventos as $evento)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($evento->data)) }}</td>
                                    <td>{{ $evento->titulo }}</td>
                                    <td>
                                        @if($evento->tipo)
                                            <span class="badge badge-{{ $evento->id_tipo == 1 ? 'primary' : 'info' }}">
                                                {{ $evento->tipo->nm_tipo }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($evento->fl_ativo)
                                            <a href="{{ url('evento/ativo/atualizar', $evento->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja desativar este evento?">
                                                <span class="badge badge-success">SIM</span>
                                            </a>
                                        @else
                                            <a href="{{ url('evento/ativo/atualizar', $evento->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja ativar este evento?">
                                                <span class="badge badge-danger">NÃO</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a title="Ver no Site" href="{{ url('eventos/detalhes', $evento->apelido) }}" class="btn btn-success btn-link btn-icon" target="_blank"><i class="fa fa-globe fa-2x"></i></a>
                                        <a title="Editar" href="{{ route('evento.edit', $evento) }}" class="btn btn-primary btn-link btn-icon"><i class="fa fa-edit fa-2x"></i></a>
                                        <form action="{{ route('evento.destroy', $evento->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Excluir" class="btn btn-danger btn-link btn-icon btn-remove" style="border: none; background: none; cursor: pointer;">
                                                <i class="fa fa-times fa-2x"></i>
                                            </button>
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
                    cancelButtonText: 'Cancelar',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then(function(result) {
                    if (result.value) {
                        location = url;
                    }
                });
            });

            // Confirmação de exclusão
            $(".btn-remove").click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');

                Swal.fire({
                    title: "Tem certeza que deseja excluir este evento?",
                    html: "<strong>Atenção:</strong> Esta ação não pode ser desfeita. A imagem do evento também será removida.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-trash text-white"></i> Sim, excluir',
                    confirmButtonColor: '#dc3545',
                    cancelButtonText: 'Cancelar',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                }).then(function(result) {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection