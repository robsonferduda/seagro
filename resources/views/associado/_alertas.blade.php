@if(session('sucesso'))
    <div class="alert alert-success as-alerta"><i class="bi bi-check-circle-fill"></i> {{ session('sucesso') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger as-alerta">
        @foreach($errors->all() as $erro)
            <div><i class="bi bi-exclamation-triangle-fill"></i> {{ $erro }}</div>
        @endforeach
    </div>
@endif
