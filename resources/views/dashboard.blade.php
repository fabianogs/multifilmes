@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="#" class="small-box-footer">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$marcas}}</h3>
                            <p>Marcas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="#">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$categorias}}</h3>
                            <p>Categorias</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-medal"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="#">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$unidades}}</h3>
                            <p>Unidades</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-store"></i>
                        </div>
                    </div>
                </a>
            </div>          
            <div class="col-lg-3 col-6">
                <a href="#">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$solucoes}}</h3>
                            <p>Soluções</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fw fa-lightbulb"></i>
                        </div>
                    </div>
                </a>
            </div>              
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href={{ asset('css/admin_custom.css') }}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@stop
