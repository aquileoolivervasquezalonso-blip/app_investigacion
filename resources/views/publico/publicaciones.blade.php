@extends('layouts.app')
@section('titulo', 'Publicaciones')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-journal-text"></i> Producción Científica</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalPublicacion"
            onclick="nuevoPublicacion()">
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
                    <th>Tipo</th>
                    <th>Autores</th>
                    <th>Medio</th>
                    <th>Año</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($publicaciones as $pub)
                <tr>
                    <td>{{ $pub->id }}</td>
                    <td>{{ $pub->titulo }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $pub->tipo }}</span></td>
                    <td>{{ $pub->autores }}</td>
                    <td>{{ $pub->medio }}</td>
                    <td>{{ $pub->anio }}</td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalPublicacion"
                                onclick='editarPublicacion(@json($pub))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('publicaciones.destroy', $pub) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta publicación?')">
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
<div class="modal fade" id="modalPublicacion" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formPublicacion" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoPublicacion" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalPublicacion"><i class="bi bi-plus-circle"></i> Agregar Publicación</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Título *</label>
              <input type="text" name="titulo" id="f_titulo" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tipo *</label>
              <select name="tipo" id="f_tipo" class="form-select" required>
                <option value="Artículo">Artículo</option>
                <option value="Libro">Libro</option>
                <option value="Patente">Patente</option>
                <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
              </select>
            </div>
            <div class="col-md-8">
              <label class="form-label">Autores</label>
              <input type="text" name="autores" id="f_autores" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Año</label>
              <input type="number" name="anio" id="f_anio" class="form-control" min="1900" max="2100">
            </div>
            <div class="col-md-6">
              <label class="form-label">Medio (Revista/Editorial)</label>
              <input type="text" name="medio" id="f_medio" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">DOI / ISBN</label>
              <input type="text" name="doi_isbn" id="f_doi_isbn" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label">Investigador</label>
              <select name="investigador_id" id="f_investigador_id" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($investigadores as $inv)
                  <option value="{{ $inv->id }}">{{ $inv->nombre_completo }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Resumen</label>
              <textarea name="resumen" id="f_resumen" class="form-control" rows="3"></textarea>
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
const formPublicacion = document.getElementById('formPublicacion');
const baseUrlPublicacion = "{{ url('publicaciones') }}";

function nuevoPublicacion() {
    formPublicacion.reset();
    document.getElementById('tituloModalPublicacion').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Publicación';
    document.getElementById('metodoPublicacion').value = 'POST';
    formPublicacion.action = baseUrlPublicacion;
}

function editarPublicacion(data) {
    formPublicacion.reset();
    document.getElementById('tituloModalPublicacion').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Publicación';
    document.getElementById('metodoPublicacion').value = 'PUT';
    formPublicacion.action = baseUrlPublicacion + '/' + data.id;
    document.getElementById('f_titulo').value = data.titulo ?? '';
    document.getElementById('f_tipo').value = data.tipo ?? 'Artículo';
    document.getElementById('f_autores').value = data.autores ?? '';
    document.getElementById('f_anio').value = data.anio ?? '';
    document.getElementById('f_medio').value = data.medio ?? '';
    document.getElementById('f_doi_isbn').value = data.doi_isbn ?? '';
    document.getElementById('f_investigador_id').value = data.investigador_id ?? '';
    document.getElementById('f_resumen').value = data.resumen ?? '';
}
</script>
@endpush
@endauth
@endsection