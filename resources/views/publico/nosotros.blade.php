@extends('layouts.app')
@section('titulo', 'Nosotros')

@section('contenido')
<h3 class="page-title text-itt mb-4"><i class="bi bi-info-circle"></i> Nosotros / Investigación</h3>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="text-itt"><i class="bi bi-bullseye"></i> Misión</h5>
                <p>Impulsar la investigación científica, tecnológica y la innovación en el Instituto Tecnológico de Tecomatlán, contribuyendo al desarrollo regional y la formación de investigadores.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="text-itt"><i class="bi bi-eye"></i> Visión</h5>
                <p>Ser un departamento de investigación reconocido por la calidad y el impacto social de sus proyectos, publicaciones y vinculación con el sector productivo.</p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="text-itt"><i class="bi bi-list-check"></i> Objetivos</h5>
                <ul>
                    <li>Fomentar la generación y aplicación del conocimiento.</li>
                    <li>Fortalecer los cuerpos académicos y las líneas de investigación.</li>
                    <li>Promover la publicación científica y la transferencia tecnológica.</li>
                    <li>Vincular la investigación con las necesidades del entorno.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
