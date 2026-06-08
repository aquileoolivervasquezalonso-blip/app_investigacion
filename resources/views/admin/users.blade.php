@extends('layouts.app')
@section('titulo', 'Usuarios')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="page-title text-itt mb-0"><i class="bi bi-people-fill"></i> Usuarios del Sistema</h3>
    <button class="btn btn-itt" data-bs-toggle="modal" data-bs-target="#modalUser"
            onclick="nuevoUser()">
        <i class="bi bi-plus-circle"></i> Agregar
    </button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>
                        @if($u->investigador && $u->investigador->foto)
                            <img src="{{ asset('storage/' . $u->investigador->foto) }}" alt="foto"
                                 style="width:42px;height:42px;object-fit:cover;border-radius:50%;">
                        @else
                            <i class="bi bi-person-circle fs-3 text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->rol === 'admin')
                            <span class="badge bg-danger"><i class="bi bi-shield-lock"></i> Administrador</span>
                        @else
                            <span class="badge bg-azul-suave text-itt"><i class="bi bi-person"></i> Investigador</span>
                        @endif
                    </td>
                    <td class="text-center text-nowrap">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalUser"
                                onclick='editarUser(@json($u))'>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('usuarios.destroy', $u) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este usuario? Si es investigador también se elimina su perfil del directorio.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Sin registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL REUTILIZABLE AGREGAR / EDITAR --}}
<div class="modal fade" id="modalUser" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="formUser" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="metodoUser" value="POST">
        <div class="modal-header card-header-itt">
          <h5 class="modal-title" id="tituloModalUser"><i class="bi bi-plus-circle"></i> Agregar Usuario</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            {{-- Datos de la cuenta --}}
            <div class="col-md-6">
              <label class="form-label">Nombre completo *</label>
              <input type="text" name="name" id="f_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Correo *</label>
              <input type="email" name="email" id="f_email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol *</label>
              <select name="rol" id="f_rol" class="form-select" required onchange="toggleCamposInvestigador()">
                <option value="investigador">Investigador</option>
                <option value="admin">Administrador</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contraseña <small id="passHint" class="text-muted"></small></label>
              <input type="password" name="password" id="f_password" class="form-control">
            </div>

            {{-- Campos del perfil de investigador (se muestran solo si rol = investigador) --}}
            <div class="col-12" id="bloqueInvestigador">
              <hr>
              <h6 class="text-itt"><i class="bi bi-person-badge"></i> Datos del Investigador (Directorio)</h6>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Grado académico</label>
                  <input type="text" name="grado_academico" id="f_grado_academico" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Especialidad</label>
                  <input type="text" name="especialidad" id="f_especialidad" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Teléfono</label>
                  <input type="text" name="telefono" id="f_telefono" class="form-control">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Cuerpo Académico</label>
                  <select name="cuerpo_academico_id" id="f_cuerpo_academico_id" class="form-select">
                    <option value="">— Ninguno —</option>
                    @foreach($cuerpos as $c)
                      <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Foto del investigador</label>
                  <input type="file" name="foto" id="f_foto" class="form-control" accept="image/*">
                  <div id="fotoActualWrap" class="mt-2 d-none">
                    <small class="text-muted d-block">Foto actual (se conserva si no subes una nueva):</small>
                    <img id="fotoActual" src="" alt="foto actual"
                         style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label">CV / Semblanza</label>
                  <textarea name="cv" id="f_cv" class="form-control" rows="3"></textarea>
                </div>
              </div>
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
const formUser = document.getElementById('formUser');
const baseUrlUser = "{{ url('usuarios') }}";
const storageBaseUser = "{{ asset('storage') }}";

function toggleCamposInvestigador() {
    const esInv = document.getElementById('f_rol').value === 'investigador';
    document.getElementById('bloqueInvestigador').style.display = esInv ? 'block' : 'none';
}

function nuevoUser() {
    formUser.reset();
    document.getElementById('tituloModalUser').innerHTML = '<i class="bi bi-plus-circle"></i> Agregar Usuario';
    document.getElementById('metodoUser').value = 'POST';
    formUser.action = baseUrlUser;
    document.getElementById('f_password').required = true;
    document.getElementById('passHint').textContent = '(requerida)';
    document.getElementById('fotoActualWrap').classList.add('d-none');
    toggleCamposInvestigador();
}

function editarUser(data) {
    formUser.reset();
    document.getElementById('tituloModalUser').innerHTML = '<i class="bi bi-pencil-square"></i> Editar Usuario';
    document.getElementById('metodoUser').value = 'PUT';
    formUser.action = baseUrlUser + '/' + data.id;
    document.getElementById('f_name').value = data.name ?? '';
    document.getElementById('f_email').value = data.email ?? '';
    document.getElementById('f_rol').value = data.rol ?? 'investigador';
    document.getElementById('f_password').required = false;
    document.getElementById('passHint').textContent = '(dejar vacío para no cambiar)';

    // datos del perfil si existe
    const inv = data.investigador;
    document.getElementById('f_grado_academico').value = inv?.grado_academico ?? '';
    document.getElementById('f_especialidad').value = inv?.especialidad ?? '';
    document.getElementById('f_telefono').value = inv?.telefono ?? '';
    document.getElementById('f_cuerpo_academico_id').value = inv?.cuerpo_academico_id ?? '';
    document.getElementById('f_cv').value = inv?.cv ?? '';

    const wrap = document.getElementById('fotoActualWrap');
    if (inv && inv.foto) {
        document.getElementById('fotoActual').src = storageBaseUser + '/' + inv.foto;
        wrap.classList.remove('d-none');
    } else {
        wrap.classList.add('d-none');
    }

    toggleCamposInvestigador();
}
</script>
@endpush
@endsection