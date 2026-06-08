@extends('layouts.app')
@section('titulo', 'Investigadores')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-person-badge"></i> Directorio de Investigadores</h3>
    @auth
    @if(auth()->user()->esAdmin())
        <a href="{{ route('usuarios.index') }}" class="btn btn-itt">
            <i class="bi bi-people-fill"></i> Gestionar desde Usuarios
        </a>
    @endif
    @endauth
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Especialidad</th>
                    <th>Cuerpo Académico</th>
                    <th>Contacto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($investigadores as $i)
                <tr>
                    <td>{{ $i->id }}</td>
                    <td>
                        @if($i->foto)
                            <img src="{{ asset('storage/' . $i->foto) }}" alt="foto"
                                 style="width:48px;height:48px;object-fit:cover;border-radius:50%;">
                        @else
                            <i class="bi bi-person-circle fs-2 text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $i->nombre_completo }}</td>
                    <td>{{ $i->grado_academico }}</td>
                    <td>{{ $i->especialidad }}</td>
                    <td>{{ $i->cuerpoAcademico->nombre ?? '—' }}</td>
                    <td>
                        @if($i->email)<div><i class="bi bi-envelope"></i> {{ $i->email }}</div>@endif
                        @if($i->telefono)<div><i class="bi bi-telephone"></i> {{ $i->telefono }}</div>@endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Sin registros. Da de alta investigadores desde la pantalla de Usuarios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection