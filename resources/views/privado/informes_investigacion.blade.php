@extends('layouts.app')
@section('titulo', 'Informes de Investigación')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-file-earmark-text"></i> Informes de Investigación</h3>
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalInformeInvestigacion"
            onclick="nuevoInformeInvestigacion()">
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
                    <th>Año</th>
                    <th>Investigador</th>
                    <th>Proyecto</th>
                    <th>Archivo</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informes as $i)
                <tr>
                    <td>{{ $i->id }}</td>
                    <td>{{ $i->titulo }}</td>
                    <td>{{ $i->anio }}</td>
                    <td>{{ $i->investigador->nombre_completo ?? '—' }}</td>
                    <td>{{ $i->proyecto->titulo ?? '—' }}</td>
                    <td>
                        @if($i->archivo)
                            @php $url = \Illuminate\Support\Str::startsWith($i->archivo, 'http') ? $i->archivo : asset('storage/' . $i->archivo); @endphp
                            <a href="{{ $url }}" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i> Ver</a>
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalInformeInvestigacion"
                                onclick='editarInformeInvestigacion(@json($i))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('informes-investigacion.destroy', $i) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este informe?')">
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
<div class="modal fade" id="modalInformeInvestigacion" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formInformeInvestigacion" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="metodoInformeInvestigacion" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalInformeInvestigacion"><i class="bi bi-plus-circle"></i> Agregar Informe</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Título *</label>
              <input type="text" name="titulo" id="f_titulo" class="form-control" required>
            </div>
            <div class="col-md-4">
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
              <label class="form-label">Proyecto</label>
              <select name="proyecto_id" id="f_proyecto_id" class="form-select">
                <option value="">— Ninguno —</option>
                @foreach($proyectos as $pr)
                  <option value="{{ $pr->id }}">{{ $pr->titulo }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-12"><hr class="my-1"><small class="text-muted">Adjunta el documento: sube un archivo <strong>o</strong> pega una URL.</small></div>

            <div class="col-md-6">
              <label class="form-label">Subir archivo</label>
              <input type="file" name="archivo_file" id="f_archivo_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
            </div>
            <div class="col-md-6">
              <label class="form-label">o URL del archivo</label>
              <input type="text" name="archivo" id="f_archivo" class="form-control" placeholder="https://...">
            </div>
            <div class="col-12 d-none" id="archivoActualWrap">
              <small class="text-muted">Archivo actual: <a id="archivoActual" href="#" target="_blank">ver</a> (se conserva si no subes uno nuevo).</small>
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
const formInformeInvestigacion = document.getElementById('formInformeInvestigacion');
const baseUrlInformeInvestigacion = "{{ url('informes-investigacion') }}";
const storageBaseInf = "{{ asset('storage') }}";

function nuevoInformeInvestigacion() {
    formInformeInvestigacion.reset();
    document.getElementById('tituloModalInformeInvestigacion').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Informe';
    document.getElementById('metodoInformeInvestigacion').value = 'POST';
    formInformeInvestigacion.action = baseUrlInformeInvestigacion;
    document.getElementById('archivoActualWrap').classList.add('d-none');
}

function editarInformeInvestigacion(data) {
    formInformeInvestigacion.reset();
    document.getElementById('tituloModalInformeInvestigacion').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Informe';
    document.getElementById('metodoInformeInvestigacion').value = 'PUT';
    formInformeInvestigacion.action = baseUrlInformeInvestigacion + '/' + data.id;
    document.getElementById('f_titulo').value = data.titulo ?? '';
    document.getElementById('f_anio').value = data.anio ?? '';
    document.getElementById('f_investigador_id').value = data.investigador_id ?? '';
    document.getElementById('f_proyecto_id').value = data.proyecto_id ?? '';
    document.getElementById('f_descripcion').value = data.descripcion ?? '';

    // Si el archivo es una URL la mostramos en el campo URL; si es archivo subido mostramos enlace "actual"
    const wrap = document.getElementById('archivoActualWrap');
    const link = document.getElementById('archivoActual');
    document.getElementById('f_archivo').value = '';
    if (data.archivo) {
        if (data.archivo.startsWith('http')) {
            document.getElementById('f_archivo').value = data.archivo;
            wrap.classList.add('d-none');
        } else {
            link.href = storageBaseInf + '/' + data.archivo;
            wrap.classList.remove('d-none');
        }
    } else {
        wrap.classList.add('d-none');
    }
}
</script>
@endpush
@endsection