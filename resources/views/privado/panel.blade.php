@extends('layouts.app')
@section('titulo', 'Panel')

@section('contenido')
<h3 class="page-title text-itt mb-4"><i class="bi bi-speedometer2"></i> Panel — Área Privada</h3>

<div class="alert bg-azul-suave text-itt">
    <i class="bi bi-person-circle"></i> Bienvenido(a), <strong>{{ auth()->user()->name }}</strong>
    ({{ auth()->user()->esAdmin() ? 'Administrador' : 'Investigador' }})
</div>

<div class="row g-3">
    <div class="col-md-3">
        <a href="{{ route('informes-investigacion.index') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 text-center p-3">
                <i class="bi bi-file-earmark-text fs-1 text-itt"></i>
                <h6 class="mt-2 text-itt">Informes de Investigación</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('planes-trabajo.index') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 text-center p-3">
                <i class="bi bi-calendar-check fs-1 text-itt"></i>
                <h6 class="mt-2 text-itt">Planes de Trabajo</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('convocatorias-prodep.index') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 text-center p-3">
                <i class="bi bi-award fs-1 text-itt"></i>
                <h6 class="mt-2 text-itt">Convocatorias PRODEP</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('asistencias-congresos.index') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 text-center p-3">
                <i class="bi bi-person-walking fs-1 text-itt"></i>
                <h6 class="mt-2 text-itt">Asistencia a Congresos</h6>
            </div>
        </a>
    </div>
    @if(auth()->user()->esAdmin())
    <div class="col-md-3">
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 text-center p-3">
                <i class="bi bi-people-fill fs-1 text-itt"></i>
                <h6 class="mt-2 text-itt">Usuarios</h6>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection