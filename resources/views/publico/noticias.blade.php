@extends('layouts.app')
@section('titulo', 'Noticias')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-newspaper"></i> Noticias</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalNoticia"
            onclick="nuevoNoticia()">
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
                    <th>Fecha</th>
                    <th>Destacada</th>
                    <th>Contenido</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($noticias as $n)
                <tr>
                    <td>{{ $n->id }}</td>
                    <td>{{ $n->titulo }}</td>
                    <td>{{ optional($n->fecha_publicacion)->format('d/m/Y') }}</td>
                    <td>
                        @if($n->destacada)
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Sí</span>
                        @else
                            <span class="badge bg-light text-muted">No</span>
                        @endif
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($n->contenido, 80) }}</td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalNoticia"
                                onclick='editarNoticia(@json($n))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('noticias.destroy', $n) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta noticia?')">
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
<div class="modal fade" id="modalNoticia" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formNoticia" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoNoticia" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalNoticia"><i class="bi bi-plus-circle"></i> Agregar Noticia</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Título *</label>
              <input type="text" name="titulo" id="f_titulo" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Fecha de Publicación *</label>
              <input type="date" name="fecha_publicacion" id="f_fecha_publicacion" class="form-control" required>
            </div>
            <div class="col-md-8">
              <label class="form-label">Imagen (URL)</label>
              <input type="text" name="imagen" id="f_imagen" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <div class="form-check">
                <input type="checkbox" name="destacada" id="f_destacada" value="1" class="form-check-input">
                <label class="form-check-label" for="f_destacada">Destacada</label>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">Contenido *</label>
              <textarea name="contenido" id="f_contenido" class="form-control" rows="4" required></textarea>
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
const formNoticia = document.getElementById('formNoticia');
const baseUrlNoticia = "{{ url('noticias') }}";

function nuevoNoticia() {
    formNoticia.reset();
    document.getElementById('tituloModalNoticia').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Noticia';
    document.getElementById('metodoNoticia').value = 'POST';
    formNoticia.action = baseUrlNoticia;
    document.getElementById('f_destacada').checked = false;
}

function editarNoticia(data) {
    formNoticia.reset();
    document.getElementById('tituloModalNoticia').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Noticia';
    document.getElementById('metodoNoticia').value = 'PUT';
    formNoticia.action = baseUrlNoticia + '/' + data.id;
    document.getElementById('f_titulo').value = data.titulo ?? '';
    document.getElementById('f_fecha_publicacion').value = data.fecha_publicacion ? data.fecha_publicacion.substring(0,10) : '';
    document.getElementById('f_imagen').value = data.imagen ?? '';
    document.getElementById('f_contenido').value = data.contenido ?? '';
    document.getElementById('f_destacada').checked = !!data.destacada;
}
</script>
@endpush
@endauth
@endsection