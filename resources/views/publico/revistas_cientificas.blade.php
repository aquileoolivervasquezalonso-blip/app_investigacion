@extends('layouts.app')
@section('titulo', 'Revistas Científicas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-book-half"></i> Revistas Científicas</h3>
    @auth
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalRevistaCientifica"
            onclick="nuevoRevistaCientifica()">
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
                    <th>Área del Conocimiento</th>
                    <th>Indexación</th>
                    <th>ISSN</th>
                    <th>Enlace</th>
                    @auth<th class="text-center">Acciones</th>@endauth
                </tr>
            </thead>
            <tbody>
                @forelse($revistas as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->nombre }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $r->area_conocimiento }}</span></td>
                    <td>{{ $r->indexacion }}</td>
                    <td>{{ $r->issn }}</td>
                    <td>
                        @if($r->enlace)
                            <a href="{{ $r->enlace }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>
                        @endif
                    </td>
                    @auth
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalRevistaCientifica"
                                onclick='editarRevistaCientifica(@json($r))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('revistas-cientificas.destroy', $r) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta revista?')">
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
<div class="modal fade" id="modalRevistaCientifica" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formRevistaCientifica" method="POST">
        @csrf
        <input type="hidden" name="_method" id="metodoRevistaCientifica" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalRevistaCientifica"><i class="bi bi-plus-circle"></i> Agregar Revista</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="f_nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">ISSN</label>
              <input type="text" name="issn" id="f_issn" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Área del Conocimiento</label>
              <input type="text" name="area_conocimiento" id="f_area_conocimiento" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Indexación (Scopus, JCR, Conahcyt...)</label>
              <input type="text" name="indexacion" id="f_indexacion" class="form-control">
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
const formRevistaCientifica = document.getElementById('formRevistaCientifica');
const baseUrlRevistaCientifica = "{{ url('revistas-cientificas') }}";

function nuevoRevistaCientifica() {
    formRevistaCientifica.reset();
    document.getElementById('tituloModalRevistaCientifica').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Revista';
    document.getElementById('metodoRevistaCientifica').value = 'POST';
    formRevistaCientifica.action = baseUrlRevistaCientifica;
}

function editarRevistaCientifica(data) {
    formRevistaCientifica.reset();
    document.getElementById('tituloModalRevistaCientifica').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Revista';
    document.getElementById('metodoRevistaCientifica').value = 'PUT';
    formRevistaCientifica.action = baseUrlRevistaCientifica + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_issn').value = data.issn ?? '';
    document.getElementById('f_area_conocimiento').value = data.area_conocimiento ?? '';
    document.getElementById('f_indexacion').value = data.indexacion ?? '';
    document.getElementById('f_enlace').value = data.enlace ?? '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';
}
</script>
@endpush
@endauth
@endsection