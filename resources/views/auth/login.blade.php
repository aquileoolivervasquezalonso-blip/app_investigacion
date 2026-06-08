@extends('layouts.app')
@section('titulo', 'Acceder')

@section('contenido')
<div class="row justify-content-center mt-4">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header card-header-itt text-center">
                <h5 class="mb-0"><i class="bi bi-lock-fill"></i> Acceso al Área Privada</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-itt w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection