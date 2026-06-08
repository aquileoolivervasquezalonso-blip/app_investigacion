@extends('layouts.app')
@section('titulo', 'Proyectos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-kanban"></i> Proyectos de Investigación</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalProyecto"
            onclick="nuevoProyecto()">
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
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th>Línea</th>
                    <th>Financiamiento</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($proyectos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->titulo }}</td>
                    <td>
                        @if($p->estado === 'En curso')
                            <span class="badge bg-success">En curso</span>
                        @else
                            <span class="badge bg-secondary">Concluido</span>
                        @endif
                    </td>
                    <td>{{ $p->investigador->nombre_completo ?? '—' }}</td>
                    <td>{{ $p->lineaInvestigacion->nombre ?? '—' }}</td>
                    <td>{{ $p->financiamiento }}</td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalProyecto"
                                onclick='editarProyecto(@json($p))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('proyectos.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este proyecto?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@auth
{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalProyecto" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formProyecto" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoProyecto" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalProyecto"><i class="bi bi-plus-circle"></i> Agregar Proyecto</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Título *</label>
              <input type="text" name="titulo" id="f_titulo" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Estado *</label>
              <select name="estado" id="f_estado" class="form-select" required>
                <option value="En curso">En curso</option>
                <option value="Concluido">Concluido</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Responsable (Investigador)</label>
              <select name="investigador_id" id="f_investigador_id" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($investigadores as $inv)
                  <option value="{{ $inv->id }}">{{ $inv->nombre_completo }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Línea de Investigación</label>
              <select name="linea_investigacion_id" id="f_linea_investigacion_id" class="form-select">
                <option value="">— Ninguna —</option>
                @foreach($lineas as $li)
                  <option value="{{ $li->id }}">{{ $li->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Financiamiento</label>
              <input type="text" name="financiamiento" id="f_financiamiento" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Monto</label>
              <input type="number" step="0.01" name="monto" id="f_monto" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Inicio</label>
              <input type="date" name="fecha_inicio" id="f_fecha_inicio" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="form-label">Fin</label>
              <input type="date" name="fecha_fin" id="f_fecha_fin" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" id="f_descripcion" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Resultados</label>
              <textarea name="resultados" id="f_resultados" class="form-control" rows="2"></textarea>
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
const formProyecto = document.getElementById('formProyecto');
const baseUrlProyecto = "{{ url('proyectos') }}";

function nuevoProyecto() {
    formProyecto.reset();
    document.getElementById('tituloModalProyecto').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Proyecto';
    document.getElementById('metodoProyecto').value = 'POST';
    formProyecto.action = baseUrlProyecto;
}

function editarProyecto(data) {
    formProyecto.reset();
    document.getElementById('tituloModalProyecto').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Proyecto';
    document.getElementById('metodoProyecto').value = 'PUT';
    formProyecto.action = baseUrlProyecto + '/' + data.id;
    document.getElementById('f_titulo').value = data.titulo ?? '';
    document.getElementById('f_estado').value = data.estado ?? 'En curso';
    document.getElementById('f_investigador_id').value = data.investigador_id ?? '';
    document.getElementById('f_linea_investigacion_id').value = data.linea_investigacion_id ?? '';
    document.getElementById('f_financiamiento').value = data.financiamiento ?? '';
    document.getElementById('f_monto').value = data.monto ?? '';
    document.getElementById('f_fecha_inicio').value = data.fecha_inicio ? data.fecha_inicio.substring(0,10) : '';
    document.getElementById('f_fecha_fin').value = data.fecha_fin ? data.fecha_fin.substring(0,10) : '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
    document.getElementById('f_resultados').value = data.resultados ?? '';
}
</script>
@endpush
@endauth
@endsection