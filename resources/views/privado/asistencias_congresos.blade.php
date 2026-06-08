@extends('layouts.app')
@section('titulo', 'Asistencia a Congresos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-person-walking"></i> Asistencia a Congresos</h3>
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalAsistenciaCongreso"
            onclick="nuevoAsistenciaCongreso()">
        <i class="bi bi-plus-circle"></i> Agregar
    </button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Congreso</th>
                    <th>Sede</th>
                    <th>Fecha</th>
                    <th>Participación</th>
                    <th>Investigador</th>
                    <th>Constancia</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asistencias as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->nombre_congreso }}</td>
                    <td>{{ $a->sede }}</td>
                    <td>{{ optional($a->fecha)->format('d/m/Y') }}</td>
                    <td><span class="badge bg-azul-suave text-itt">{{ $a->tipo_participacion }}</span></td>
                    <td>{{ $a->investigador->nombre_completo ?? '—' }}</td>
                    <td>
                        @if($a->constancia)
                            @php $urlCons = \Illuminate\Support\Str::startsWith($a->constancia, 'http') ? $a->constancia : asset('storage/' . $a->constancia); @endphp
                            <a href="{{ $urlCons }}" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i> Ver</a>
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalAsistenciaCongreso"
                                onclick='editarAsistenciaCongreso(@json($a))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('asistencias-congresos.destroy', $a) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este registro?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalAsistenciaCongreso" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formAsistenciaCongreso" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="metodoAsistenciaCongreso" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalAsistenciaCongreso"><i class="bi bi-plus-circle"></i> Agregar Asistencia</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Nombre del Congreso *</label>
              <input type="text" name="nombre_congreso" id="f_nombre_congreso" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tipo de Participación *</label>
              <select name="tipo_participacion" id="f_tipo_participacion" class="form-select" required>
                <option value="Asistente">Asistente</option>
                <option value="Ponente">Ponente</option>
                <option value="Cartel">Cartel</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Sede</label>
              <input type="text" name="sede" id="f_sede" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha</label>
              <input type="date" name="fecha" id="f_fecha" class="form-control">
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
              <label class="form-label">Título de la Ponencia</label>
              <input type="text" name="titulo_ponencia" id="f_titulo_ponencia" class="form-control">
            </div>

            <div class="col-12"><hr class="my-1"><small class="text-muted">Adjunta la constancia: sube un archivo <strong>o</strong> pega una URL.</small></div>

            <div class="col-md-6">
              <label class="form-label">Subir constancia</label>
              <input type="file" name="constancia_file" id="f_constancia_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="col-md-6">
              <label class="form-label">o URL de la constancia</label>
              <input type="text" name="constancia" id="f_constancia" class="form-control" placeholder="https://...">
            </div>
            <div class="col-12 d-none" id="constanciaActualWrap">
              <small class="text-muted">Constancia actual: <a id="constanciaActual" href="#" target="_blank">ver</a> (se conserva si no subes una nueva).</small>
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
const formAsistenciaCongreso = document.getElementById('formAsistenciaCongreso');
const baseUrlAsistenciaCongreso = "{{ url('asistencias-congresos') }}";
const storageBaseAsis = "{{ asset('storage') }}";

function nuevoAsistenciaCongreso() {
    formAsistenciaCongreso.reset();
    document.getElementById('tituloModalAsistenciaCongreso').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Asistencia';
    document.getElementById('metodoAsistenciaCongreso').value = 'POST';
    formAsistenciaCongreso.action = baseUrlAsistenciaCongreso;
    document.getElementById('constanciaActualWrap').classList.add('d-none');
}

function editarAsistenciaCongreso(data) {
    formAsistenciaCongreso.reset();
    document.getElementById('tituloModalAsistenciaCongreso').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Asistencia';
    document.getElementById('metodoAsistenciaCongreso').value = 'PUT';
    formAsistenciaCongreso.action = baseUrlAsistenciaCongreso + '/' + data.id;
    document.getElementById('f_nombre_congreso').value = data.nombre_congreso ?? '';
    document.getElementById('f_tipo_participacion').value = data.tipo_participacion ?? 'Asistente';
    document.getElementById('f_sede').value = data.sede ?? '';
    document.getElementById('f_fecha').value = data.fecha ? data.fecha.substring(0,10) : '';
    document.getElementById('f_investigador_id').value = data.investigador_id ?? '';
    document.getElementById('f_titulo_ponencia').value = data.titulo_ponencia ?? '';

    const wrap = document.getElementById('constanciaActualWrap');
    const link = document.getElementById('constanciaActual');
    document.getElementById('f_constancia').value = '';
    if (data.constancia) {
        if (data.constancia.startsWith('http')) {
            document.getElementById('f_constancia').value = data.constancia;
            wrap.classList.add('d-none');
        } else {
            link.href = storageBaseAsis + '/' + data.constancia;
            wrap.classList.remove('d-none');
        }
    } else {
        wrap.classList.add('d-none');
    }
}
</script>
@endpush
@endsection