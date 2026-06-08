@extends('layouts.app')
@section('titulo', 'Convocatorias de Congresos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-megaphone"></i> Convocatorias de Congresos</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalConvocatoriaCongreso"
            onclick="nuevoConvocatoriaCongreso()">
        <i class="bi bi-plus-circle"></i> Agregar
    </button>
    @endauth
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Sede</th>
                    <th>Fecha Evento</th>
                    <th>Fecha Límite</th>
                    <th>Estado</th>
                    <th>Enlace</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($convocatorias as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->sede }}</td>
                    <td>{{ optional($c->fecha_evento)->format('d/m/Y') }}</td>
                    <td>{{ optional($c->fecha_limite)->format('d/m/Y') }}</td>
                    <td>
                        @if($c->estado === 'Abierta')
                            <span class="badge bg-success">Abierta</span>
                        @else
                            <span class="badge bg-secondary">Cerrada</span>
                        @endif
                    </td>
                    <td>
                        @if($c->enlace)
                            <a href="{{ $c->enlace }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>
                        @endif
                    </td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalConvocatoriaCongreso"
                                onclick='editarConvocatoriaCongreso(@json($c))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('convocatorias-congresos.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta convocatoria?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@auth
{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalConvocatoriaCongreso" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formConvocatoriaCongreso" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoConvocatoriaCongreso" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalConvocatoriaCongreso"><i class="bi bi-plus-circle"></i> Agregar Convocatoria</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="f_nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Estado *</label>
              <select name="estado" id="f_estado" class="form-select" required>
                <option value="Abierta">Abierta</option>
                <option value="Cerrada">Cerrada</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Sede</label>
              <input type="text" name="sede" id="f_sede" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha del Evento</label>
              <input type="date" name="fecha_evento" id="f_fecha_evento" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha Límite</label>
              <input type="date" name="fecha_limite" id="f_fecha_limite" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Enlace</label>
              <input type="text" name="enlace" id="f_enlace" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" id="f_descripcion" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cancelar</button>
          <button type="submit" class="btn btn-itt"><i class="bi bi-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
const formConvocatoriaCongreso = document.getElementById('formConvocatoriaCongreso');
const baseUrlConvocatoriaCongreso = "{{ url('convocatorias-congresos') }}";

function nuevoConvocatoriaCongreso() {
    formConvocatoriaCongreso.reset();
    document.getElementById('tituloModalConvocatoriaCongreso').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Convocatoria';
    document.getElementById('metodoConvocatoriaCongreso').value = 'POST';
    formConvocatoriaCongreso.action = baseUrlConvocatoriaCongreso;
}

function editarConvocatoriaCongreso(data) {
    formConvocatoriaCongreso.reset();
    document.getElementById('tituloModalConvocatoriaCongreso').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Convocatoria';
    document.getElementById('metodoConvocatoriaCongreso').value = 'PUT';
    formConvocatoriaCongreso.action = baseUrlConvocatoriaCongreso + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_estado').value = data.estado ?? 'Abierta';
    document.getElementById('f_sede').value = data.sede ?? '';
    document.getElementById('f_fecha_evento').value = data.fecha_evento ? data.fecha_evento.substring(0,10) : '';
    document.getElementById('f_fecha_limite').value = data.fecha_limite ? data.fecha_limite.substring(0,10) : '';
    document.getElementById('f_enlace').value = data.enlace ?? '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
}
</script>
@endpush
@endauth
@endsection