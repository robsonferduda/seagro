@extends('layouts.admin')
@section('content')
    <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa fa-files-o text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Boletins</p>
                      <p class="card-title"><a href="{{ url('boletins') }}">{{ $boletins->count() }}</a><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                    Atualizado em {{ date('d/m/Y', strtotime($boletins[0]->created_at)) }}
                </div>
              </div>
            </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="fa fa-globe text-primary"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Páginas</p>
                      <p class="card-title"><a href="{{ url('paginas') }}">{{ $paginas->count() }}</a><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-refresh"></i>
                  Atualizado em {{ date('d/m/Y', strtotime($paginas[0]->created_at)) }}
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection