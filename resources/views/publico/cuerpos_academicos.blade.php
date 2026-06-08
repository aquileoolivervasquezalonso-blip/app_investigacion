@extends('layouts.app')
@section('titulo', 'Cuerpos Académicos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-people"></i> Cuerpos Académicos</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalCuerpoAcademico"
            onclick="nuevoCuerpoAcademico()">
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
                    <th>Clave</th>
                    <th>Grado de Consolidación</th>
                    <th>Descripción</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($cuerpos as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->clave }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $c->grado_consolidacion }}</span></td>
                    <td>{{ \Illuminate\Support\Str::limit($c->descripcion, 80) }}</td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalCuerpoAcademico"
                                onclick='editarCuerpoAcademico(@json($c))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('cuerpos-academicos.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este cuerpo académico?')">
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
<div class="modal fade" id="modalCuerpoAcademico" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formCuerpoAcademico" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoCuerpoAcademico" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalCuerpoAcademico"><i class="bi bi-plus-circle"></i> Agregar Cuerpo Académico</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="f_nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Clave</label>
              <input type="text" name="clave" id="f_clave" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Grado de Consolidación *</label>
              <select name="grado_consolidacion" id="f_grado_consolidacion" class="form-select" required>
                <option value="En Formación">En Formación</option>
                <option value="En Consolidación">En Consolidación</option>
                <option value="Consolidado">Consolidado</option>
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
const formCuerpoAcademico = document.getElementById('formCuerpoAcademico');
const baseUrlCuerpoAcademico = "{{ url('cuerpos-academicos') }}";

function nuevoCuerpoAcademico() {
    formCuerpoAcademico.reset();
    document.getElementById('tituloModalCuerpoAcademico').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Cuerpo Académico';
    document.getElementById('metodoCuerpoAcademico').value = 'POST';
    formCuerpoAcademico.action = baseUrlCuerpoAcademico;
}

function editarCuerpoAcademico(data) {
    formCuerpoAcademico.reset();
    document.getElementById('tituloModalCuerpoAcademico').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Cuerpo Académico';
    document.getElementById('metodoCuerpoAcademico').value = 'PUT';
    formCuerpoAcademico.action = baseUrlCuerpoAcademico + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_clave').value = data.clave ?? '';
    document.getElementById('f_grado_consolidacion').value = data.grado_consolidacion ?? 'En Formación';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
}
</script>
@endpush
@endauth
@endsection