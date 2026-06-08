@extends('layouts.app')
@section('titulo', 'Inicio')

@section('contenido')
{{-- HERO --}}
<div class="card text-white mb-4" style="background: linear-gradient(135deg, var(--azul-itt), var(--azul-itt-claro));">
    <div class="card-body py-5 text-center">
        <h1 class="fw-bold"><i class="bi bi-mortarboard-fill"></i> Coordinación de Investigación</h1>
        <p class="lead mb-0">Instituto Tecnológico de Tecomatlán — «Cultivar la tierra y la conciencia del hombre»</p>
    </div>
</div>

{{-- INDICADORES --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-kanban fs-1 text-itt"></i>
            <h2 class="text-itt mb-0">{{ $totales['proyectos'] }}</h2>
            <span class="text-muted">Proyectos</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-journal-text fs-1 text-itt"></i>
            <h2 class="text-itt mb-0">{{ $totales['publicaciones'] }}</h2>
            <span class="text-muted">Publicaciones</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-person-badge fs-1 text-itt"></i>
            <h2 class="text-itt mb-0">{{ $totales['investigadores'] }}</h2>
            <span class="text-muted">Investigadores</span>
        </div>
    </div>
</div>

{{-- DESTACADAS --}}
@if($destacadas->count())
<h4 class="page-title text-itt mb-3"><i class="bi bi-star-fill"></i> Noticias Destacadas</h4>
<div class="row g-3 mb-4">
    @foreach($destacadas as $n)
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            @if($n->imagen)<img src="{{ $n->imagen }}" class="card-img-top" style="height:160px;object-fit:cover;">@endif
            <div class="card-body">
                <h6 class="card-title text-itt">{{ $n->titulo }}</h6>
                <small class="text-muted"><i class="bi bi-calendar"></i> {{ optional($n->fecha_publicacion)->format('d/m/Y') }}</small>
                <p class="card-text mt-2">{{ \Illuminate\Support\Str::limit($n->contenido, 110) }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ACCESOS RÁPIDOS --}}
<h4 class="page-title text-itt mb-3"><i class="bi bi-grid"></i> Accesos Rápidos</h4>
<div class="row g-3">
    <div class="col-6 col-md-3"><a href="{{ route('investigadores.index') }}" class="text-decoration-none"><div class="card shadow-sm text-center p-3"><i class="bi bi-person-badge fs-2 text-itt"></i><div class="text-itt mt-1">Investigadores</div></div></a></div>
    <div class="col-6 col-md-3"><a href="{{ route('proyectos.index') }}" class="text-decoration-none"><div class="card shadow-sm text-center p-3"><i class="bi bi-kanban fs-2 text-itt"></i><div class="text-itt mt-1">Proyectos</div></div></a></div>
    <div class="col-6 col-md-3"><a href="{{ route('publicaciones.index') }}" class="text-decoration-none"><div class="card shadow-sm text-center p-3"><i class="bi bi-journal-text fs-2 text-itt"></i><div class="text-itt mt-1">Publicaciones</div></div></a></div>
    <div class="col-6 col-md-3"><a href="{{ route('convocatorias-congresos.index') }}" class="text-decoration-none"><div class="card shadow-sm text-center p-3"><i class="bi bi-megaphone fs-2 text-itt"></i><div class="text-itt mt-1">Convocatorias</div></div></a></div>
</div>
@endsection