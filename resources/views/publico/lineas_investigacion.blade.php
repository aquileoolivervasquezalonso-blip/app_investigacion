@extends('layouts.app')
@section('titulo', 'Líneas de Investigación')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-signpost-split"></i> Líneas de Investigación</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalLineaInvestigacion"
            onclick="nuevoLineaInvestigacion()">
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
                    <th>Carrera</th>
                    <th>Descripción</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($lineas as $l)
                <tr>
                    <td>{{ $l->id }}</td>
                    <td>{{ $l->nombre }}</td>
                    <td>{{ $l->cuerpoAcademico->nombre ?? '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($l->descripcion, 90) }}</td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalLineaInvestigacion"
                                onclick='editarLineaInvestigacion(@json($l))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('lineas-investigacion.destroy', $l) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta línea?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endauth
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@auth
{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalLineaInvestigacion" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formLineaInvestigacion" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoLineaInvestigacion" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalLineaInvestigacion"><i class="bi bi-plus-circle"></i> Agregar Línea</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-7">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="f_nombre" class="form-control" required>
            </div>
            <div class="col-md-5">
              <label class="form-label">Cuerpo Académico</label>
              <select name="cuerpo_academico_id" id="f_cuerpo_academico_id" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($cuerpos as $c)
                  <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
              </select>
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
const formLineaInvestigacion = document.getElementById('formLineaInvestigacion');
const baseUrlLineaInvestigacion = "{{ url('lineas-investigacion') }}";

function nuevoLineaInvestigacion() {
    formLineaInvestigacion.reset();
    document.getElementById('tituloModalLineaInvestigacion').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Línea';
    document.getElementById('metodoLineaInvestigacion').value = 'POST';
    formLineaInvestigacion.action = baseUrlLineaInvestigacion;
}

function editarLineaInvestigacion(data) {
    formLineaInvestigacion.reset();
    document.getElementById('tituloModalLineaInvestigacion').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Línea';
    document.getElementById('metodoLineaInvestigacion').value = 'PUT';
    formLineaInvestigacion.action = baseUrlLineaInvestigacion + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
    document.getElementById('f_cuerpo_academico_id').value = data.cuerpo_academico_id ?? '';
}
</script>
@endpush
@endauth
@endsection