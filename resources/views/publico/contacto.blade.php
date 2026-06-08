@extends('layouts.app')
@section('titulo', 'Contacto')

@section('contenido')
<h3 class="page-title text-itt mb-4"><i class="bi bi-envelope"></i> Contacto</h3>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="text-itt mb-3">Departamento de Investigación</h5>
                <p><i class="bi bi-geo-alt-fill text-itt"></i> Tecomatlán, Puebla, México</p>
                <p><i class="bi bi-telephone-fill text-itt"></i> (272) 000 0000</p>
                <p><i class="bi bi-envelope-fill text-itt"></i> investigacion@ittecomatlan.edu.mx</p>
                <p><i class="bi bi-clock-fill text-itt"></i> Lunes a Viernes, 8:00 - 16:00 hrs</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="text-itt mb-3">Enlaces Rápidos</h5>
                <div class="list-group">
                    <a href="{{ route('investigadores.index') }}" class="list-group-item list-group-item-action"><i class="bi bi-person-badge text-itt"></i> Directorio de Investigadores</a>
                    <a href="{{ route('proyectos.index') }}" class="list-group-item list-group-item-action"><i class="bi bi-kanban text-itt"></i> Proyectos</a>
                    <a href="{{ route('convocatorias-congresos.index') }}" class="list-group-item list-group-item-action"><i class="bi bi-megaphone text-itt"></i> Convocatorias</a>
                    <a href="{{ route('revistas-cientificas.index') }}" class="list-group-item list-group-item-action"><i class="bi bi-book-half text-itt"></i> Revistas Científicas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
