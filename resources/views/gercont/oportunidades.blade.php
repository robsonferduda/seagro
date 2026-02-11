@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="nc-icon nc-briefcase-24"></i> Oportunidades</h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('oportunidades/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
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
                                <th>Título</th>
                                <th>Empresa</th>
                                <th>Tipo</th>
                                <th>Localização</th>
                                <th>Publicação</th>
                                <th>Validade</th>
                                <th>Visualizações</th>
                                <th class="text-center">Ativo</th>
                                <th class="disabled-sorting text-center">Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            @foreach($oportunidades as $oportunidade)
                                <tr>
                                    <td>{{ $oportunidade->titulo }}</td>
                                    <td>{{ $oportunidade->empresa }}</td>
                                    <td>
                                        @if($oportunidade->tipo == 'Emprego')
                                            <span class="badge badge-primary">Emprego</span>
                                        @elseif($oportunidade->tipo == 'Estágio')
                                            <span class="badge badge-info">Estágio</span>
                                        @else
                                            <span class="badge badge-secondary">Freelance</span>
                                        @endif
                                    </td>
                                    <td>{{ $oportunidade->localizacao }}</td>
                                    <td>{{ date('d/m/Y', strtotime($oportunidade->dt_publicacao)) }}</td>
                                    <td>
                                        @if($oportunidade->dt_validade)
                                            @if($oportunidade->isValida())
                                                <span class="text-success">{{ date('d/m/Y', strtotime($oportunidade->dt_validade)) }}</span>
                                            @else
                                                <span class="text-danger">{{ date('d/m/Y', strtotime($oportunidade->dt_validade)) }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Indeterminado</span>
                                        @endif
                                    </td>
                                    <td>{{ $oportunidade->visualizacoes }}</td>
                                    <td class="text-center">
                                        @if($oportunidade->fl_ativo)
                                            <a href="{{ url('oportunidades/atualizar', $oportunidade->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja desativar esta oportunidade?">
                                                <span class="badge badge-success">SIM</span>
                                            </a>
                                        @else
                                            <a href="{{ url('oportunidades/atualizar', $oportunidade->id) }}" class="btn-confirmation" data-msg="Tem certeza que deseja ativar esta oportunidade?">
                                                <span class="badge badge-danger">NÃO</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a title="Ver no Site" href="{{ url('oportunidades/show', $oportunidade->id) }}" class="btn btn-success btn-link btn-icon" target="_blank"><i class="fa fa-globe fa-2x"></i></a>
                                        <a title="Editar" href="{{ route('oportunidade.edit', $oportunidade) }}" class="btn btn-primary btn-link btn-icon"><i class="fa fa-edit fa-2x"></i></a>
                                        <form action="{{ route('oportunidade.destroy', $oportunidade->id) }}" method="POST" class="d-inline form-delete">
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
                    cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
                    cancelButtonColor: '#F64E60'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });

            $(".btn-remove").on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest("form");
                
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, excluir',
                    confirmButtonColor: '#F64E60',
                    cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
                    cancelButtonColor: '#1BC5BD'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('oportunidades') }}/" + id + "/destroy";
        }
    });
}
</script>

@endsection
