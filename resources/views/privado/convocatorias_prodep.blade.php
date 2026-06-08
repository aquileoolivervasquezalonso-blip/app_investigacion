@extends('layouts.app')
@section('titulo', 'Convocatorias PRODEP')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-award"></i> Convocatorias PRODEP</h3>
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalConvocatoriaProdep"
            onclick="nuevoConvocatoriaProdep()">
        <i class="bi bi-plus-circle"></i> Agregar
    </button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Publicación</th>
                    <th>Fecha Límite</th>
                    <th>Estado</th>
                    <th>Recursos</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($convocatorias as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ optional($c->fecha_publicacion)->format('d/m/Y') }}</td>
                    <td>{{ optional($c->fecha_limite)->format('d/m/Y') }}</td>
                    <td>
                        @if($c->estado === 'Abierta')
                            <span class="badge bg-success">Abierta</span>
                        @else
                            <span class="badge bg-secondary">Cerrada</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @if($c->archivo)
                            @php $urlArch = \Illuminate\Support\Str::startsWith($c->archivo, 'http') ? $c->archivo : asset('storage/' . $c->archivo); @endphp
                            <a href="{{ $urlArch }}" target="_blank" title="Archivo"><i class="bi bi-file-earmark-arrow-down"></i></a>
                        @endif
                        @if($c->enlace)<a href="{{ $c->enlace }}" target="_blank" title="Enlace" class="ms-2"><i class="bi bi-box-arrow-up-right"></i></a>@endif
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalConvocatoriaProdep"
                                onclick='editarConvocatoriaProdep(@json($c))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('convocatorias-prodep.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta convocatoria?')">
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
<div class="modal fade" id="modalConvocatoriaProdep" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formConvocatoriaProdep" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="metodoConvocatoriaProdep" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalConvocatoriaProdep"><i class="bi bi-plus-circle"></i> Agregar Convocatoria PRODEP</h5>
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
            <div class="col-md-6">
              <label class="form-label">Fecha de Publicación</label>
              <input type="date" name="fecha_publicacion" id="f_fecha_publicacion" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha Límite</label>
              <input type="date" name="fecha_limite" id="f_fecha_limite" class="form-control">
            </div>

            <div class="col-12"><hr class="my-1"><small class="text-muted">Adjunta la convocatoria: sube un archivo <strong>o</strong> pega una URL.</small></div>

            <div class="col-md-6">
              <label class="form-label">Subir archivo</label>
              <input type="file" name="archivo_file" id="f_archivo_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
            </div>
            <div class="col-md-6">
              <label class="form-label">o URL del archivo</label>
              <input type="text" name="archivo" id="f_archivo" class="form-control" placeholder="https://...">
            </div>
            <div class="col-12 d-none" id="archivoActualWrapProdep">
              <small class="text-muted">Archivo actual: <a id="archivoActualProdep" href="#" target="_blank">ver</a> (se conserva si no subes uno nuevo).</small>
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
const formConvocatoriaProdep = document.getElementById('formConvocatoriaProdep');
const baseUrlConvocatoriaProdep = "{{ url('convocatorias-prodep') }}";
const storageBaseProdep = "{{ asset('storage') }}";

function nuevoConvocatoriaProdep() {
    formConvocatoriaProdep.reset();
    document.getElementById('tituloModalConvocatoriaProdep').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Convocatoria PRODEP';
    document.getElementById('metodoConvocatoriaProdep').value = 'POST';
    formConvocatoriaProdep.action = baseUrlConvocatoriaProdep;
    document.getElementById('archivoActualWrapProdep').classList.add('d-none');
}

function editarConvocatoriaProdep(data) {
    formConvocatoriaProdep.reset();
    document.getElementById('tituloModalConvocatoriaProdep').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Convocatoria PRODEP';
    document.getElementById('metodoConvocatoriaProdep').value = 'PUT';
    formConvocatoriaProdep.action = baseUrlConvocatoriaProdep + '/' + data.id;
    document.getElementById('f_nombre').value = data.nombre ?? '';
    document.getElementById('f_estado').value = data.estado ?? 'Abierta';
    document.getElementById('f_fecha_publicacion').value = data.fecha_publicacion ? data.fecha_publicacion.substring(0,10) : '';
    document.getElementById('f_fecha_limite').value = data.fecha_limite ? data.fecha_limite.substring(0,10) : '';
    document.getElementById('f_enlace').value = data.enlace ?? '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';

    const wrap = document.getElementById('archivoActualWrapProdep');
    const link = document.getElementById('archivoActualProdep');
    document.getElementById('f_archivo').value = '';
    if (data.archivo) {
        if (data.archivo.startsWith('http')) {
            document.getElementById('f_archivo').value = data.archivo;
            wrap.classList.add('d-none');
        } else {
            link.href = storageBaseProdep + '/' + data.archivo;
            wrap.classList.remove('d-none');
        }
    } else {
        wrap.classList.add('d-none');
    }
}
</script>
@endpush
@endsection