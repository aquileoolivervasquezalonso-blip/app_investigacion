@extends('layouts.app')
@section('titulo', 'Vinculación')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-building"></i> Vinculación y Transferencia</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalVinculacion"
            onclick="nuevoVinculacion()">
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
                    <th>Tipo</th>
                    <th>Institución</th>
                    <th>Vigencia</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($vinculaciones as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->nombre }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $v->tipo }}</span></td>
                    <td>{{ $v->institucion }}</td>
                    <td>
                        {{ optional($v->fecha_inicio)->format('d/m/Y') }}
                        @if($v->fecha_fin) — {{ $v->fecha_fin->format('d/m/Y') }}@endif
                    </td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalVinculacion"
                                onclick='editarVinculacion(@json($v))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('vinculaciones.destroy', $v) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta vinculación?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@auth
{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalVinculacion" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formVinculacion" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoVinculacion" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalVinculacion"><i class="bi bi-plus-circle"></i> Agregar Vinculación</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="f_nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tipo *</label>
              <select name="tipo" id="f_tipo" class="form-select" required>
                <option value="Servicio Tecnológico">Servicio Tecnológico</option>
                <option value="Consultoría">Consultoría</option>
                <option value="Convenio">Convenio</option>
                <option value="Transferencia Tecnológica">Transferencia Tecnológica</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Institución</label>
              <input type="text" name="institucion" id="f_institucion" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha Inicio</label>
              <input type="date" name="fecha_inicio" id="f_fecha_inicio" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha Fin</label>
              <input type="date" name="fecha_fin" id="f_fecha_fin" class="form-control">
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
const formVinculacion = document.getElementById('formVinculacion');
const baseUrlVinculacion = "{{ url('vinculaciones') }}";

function nuevoVinculacion() {
    formVinculacion.reset();
    document.getElementById('tituloModalVinculacion').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Vinculación';
    document.getElementById('metodoVinculacion').value = 'POST';
    formVinculacion.action = baseUrlVinculacion;
}

function editarVinculacion(data) {
    formVinculacion.reset();
    document.getElementById('tituloModalVinculacion').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Vinculación';
    document.getElementById('metodoVinculacion').value = 'PUT';
    formVinculacion.action = baseUrlVinculacion + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_tipo').value = data.tipo ?? 'Convenio';
    document.getElementById('f_institucion').value = data.institucion ?? '';
    document.getElementById('f_fecha_inicio').value = data.fecha_inicio ? data.fecha_inicio.substring(0,10) : '';
    document.getElementById('f_fecha_fin').value = data.fecha_fin ? data.fecha_fin.substring(0,10) : '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
}
</script>
@endpush
@endauth
@endsection