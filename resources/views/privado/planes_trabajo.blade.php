@extends('layouts.app')
@section('titulo', 'Planes de Trabajo')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-calendar-check"></i> Planes de Trabajo</h3>
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalPlanTrabajo"
            onclick="nuevoPlanTrabajo()">
        <i class="bi bi-plus-circle"></i> Agregar
    </button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Año</th>
                    <th>Investigador</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($planes as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->titulo }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $p->tipo }}</span></td>
                    <td>{{ $p->anio }}</td>
                    <td>{{ $p->investigador->nombre_completo ?? '—' }}</td>
                    <td>
                        @switch($p->estado)
                            @case('Aprobado') <span class="badge bg-success">Aprobado</span> @break
                            @case('Enviado') <span class="badge bg-info text-dark">Enviado</span> @break
                            @default <span class="badge bg-secondary">Borrador</span>
                        @endswitch
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalPlanTrabajo"
                                onclick='editarPlanTrabajo(@json($p))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('planes-trabajo.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este plan?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalPlanTrabajo" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formPlanTrabajo" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoPlanTrabajo" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalPlanTrabajo"><i class="bi bi-plus-circle"></i> Agregar Plan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Título *</label>
              <input type="text" name="titulo" id="f_titulo" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Tipo *</label>
              <select name="tipo" id="f_tipo" class="form-select" required>
                <option value="Individual">Individual</option>
                <option value="Anual">Anual</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Año</label>
              <input type="number" name="anio" id="f_anio" class="form-control" min="1900" max="2100">
            </div>
            <div class="col-md-6">
              <label class="form-label">Investigador</label>
              <select name="investigador_id" id="f_investigador_id" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($investigadores as $inv)
                  <option value="{{ $inv->id }}">{{ $inv->nombre_completo }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Estado *</label>
              <select name="estado" id="f_estado" class="form-select" required>
                <option value="Borrador">Borrador</option>
                <option value="Enviado">Enviado</option>
                <option value="Aprobado">Aprobado</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Objetivos</label>
              <textarea name="objetivos" id="f_objetivos" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Actividades</label>
              <textarea name="actividades" id="f_actividades" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Metas</label>
              <textarea name="metas" id="f_metas" class="form-control" rows="2"></textarea>
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
const formPlanTrabajo = document.getElementById('formPlanTrabajo');
const baseUrlPlanTrabajo = "{{ url('planes-trabajo') }}";

function nuevoPlanTrabajo() {
    formPlanTrabajo.reset();
    document.getElementById('tituloModalPlanTrabajo').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Plan';
    document.getElementById('metodoPlanTrabajo').value = 'POST';
    formPlanTrabajo.action = baseUrlPlanTrabajo;
}

function editarPlanTrabajo(data) {
    formPlanTrabajo.reset();
    document.getElementById('tituloModalPlanTrabajo').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Plan';
    document.getElementById('metodoPlanTrabajo').value = 'PUT';
    formPlanTrabajo.action = baseUrlPlanTrabajo + '/' + data.id;
    document.getElementById('f_titulo').value = data.titulo ?? '';
    document.getElementById('f_tipo').value = data.tipo ?? 'Individual';
    document.getElementById('f_anio').value = data.anio ?? '';
    document.getElementById('f_investigador_id').value = data.investigador_id ?? '';
    document.getElementById('f_estado').value = data.estado ?? 'Borrador';
    document.getElementById('f_objetivos').value = data.objetivos ?? '';
    document.getElementById('f_actividades').value = data.actividades ?? '';
    document.getElementById('f_metas').value = data.metas ?? '';
}
</script>
@endpush
@endsection