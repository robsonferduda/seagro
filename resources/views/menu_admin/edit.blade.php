@extends('layouts.admin')

@section('style')
@include('partials.admin_form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-list-ul"></i> Editar menu</h3>
            <p>{{ $menu->descricao }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/menus') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('menu-admin/' . $menu->id) }}" id="formMenu">
        @csrf
        @include('menu_admin.partials.form')
    </form>
</div>
@endsection

@section('script')
@include('menu_admin.partials.form_script')
@endsection
