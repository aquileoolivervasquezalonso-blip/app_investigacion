<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Coordinación de Investigación') | ITT</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-itt: #0d3b66;
            --azul-itt-claro: #1d5a9c;
            --azul-suave: #e7f0fa;
        }
        body { background: #f4f6f9; }
        .membrete {
            background: #fff;
            border-bottom: 4px solid var(--azul-itt);
        }
        .membrete img { max-height: 70px; object-fit: contain; }
        .navbar-itt { background: var(--azul-itt) !important; }
        .navbar-itt .nav-link { color: #dce8f5 !important; font-weight: 500; }
        .navbar-itt .nav-link:hover,
        .navbar-itt .nav-link.active { color: #fff !important; }
        .navbar-itt .dropdown-menu { border-radius: 0 0 .5rem .5rem; }
        .card-header-itt { background: var(--azul-itt); color: #fff; }
        .btn-itt { background: var(--azul-itt); color: #fff; }
        .btn-itt:hover { background: var(--azul-itt-claro); color: #fff; }
        .text-itt { color: var(--azul-itt); }
        .bg-azul-suave { background: var(--azul-suave); }
        .table thead th { background: var(--azul-itt); color: #fff; }
        footer.footer-itt { background: var(--azul-itt); color: #cfe0f2; }
        .page-title { border-left: 5px solid var(--azul-itt); padding-left: .75rem; }
    </style>
    @stack('estilos')
</head>
<body>

    {{-- MEMBRETE --}}
    <header class="membrete py-2">
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
            <img src="{{ asset('img/sep.jpg') }}" alt="SEP">
            <div class="text-center flex-grow-1 px-2 d-none d-md-block">
                <div class="fw-bold text-itt" style="font-size:1.05rem;line-height:1.2;">
                    INSTITUTO TECNOLÓGICO DE TECOMATLÁN
                </div>
                <small class="text-muted">Coordinación de Investigación</small>
            </div>
            <img src="{{ asset('img/tecnm.jpg') }}" alt="TecNM">
            <img src="{{ asset('img/itt.jpg') }}" alt="ITT">
        </div>
    </header>

    {{-- BARRA DE MENÚ SUPERIOR --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-itt sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('inicio') }}">
                <i class="bi bi-mortarboard-fill"></i> ITT Investigación
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('inicio') }}"><i class="bi bi-house-door"></i> Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('nosotros') }}"><i class="bi bi-info-circle"></i> Nosotros</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-diagram-3"></i> Investigación</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('cuerpos-academicos.index') }}"><i class="bi bi-people"></i> Cuerpos Académicos</a></li>
                            <li><a class="dropdown-item" href="{{ route('lineas-investigacion.index') }}"><i class="bi bi-signpost-split"></i> Líneas de Investigación</a></li>
                            <li><a class="dropdown-item" href="{{ route('investigadores.index') }}"><i class="bi bi-person-badge"></i> Investigadores</a></li>
                            <li><a class="dropdown-item" href="{{ route('proyectos.index') }}"><i class="bi bi-kanban"></i> Proyectos</a></li>
                            <li><a class="dropdown-item" href="{{ route('publicaciones.index') }}"><i class="bi bi-journal-text"></i> Publicaciones</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-link-45deg"></i> Difusión</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('vinculaciones.index') }}"><i class="bi bi-building"></i> Vinculación</a></li>
                            <li><a class="dropdown-item" href="{{ route('convocatorias-congresos.index') }}"><i class="bi bi-megaphone"></i> Convocatorias Congresos</a></li>
                            <li><a class="dropdown-item" href="{{ route('revistas-cientificas.index') }}"><i class="bi bi-book-half"></i> Revistas Científicas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contacto') }}"><i class="bi bi-envelope"></i> Contacto</a></li>
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-lock-fill"></i> Área Privada
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('panel') }}"><i class="bi bi-speedometer2"></i> Panel</a></li>
                                <li><a class="dropdown-item" href="{{ route('informes-investigacion.index') }}"><i class="bi bi-file-earmark-text"></i> Informes</a></li>
                                <li><a class="dropdown-item" href="{{ route('planes-trabajo.index') }}"><i class="bi bi-calendar-check"></i> Planes de Trabajo</a></li>
                                <li><a class="dropdown-item" href="{{ route('convocatorias-prodep.index') }}"><i class="bi bi-award"></i> Convocatorias PRODEP</a></li>
                                <li><a class="dropdown-item" href="{{ route('asistencias-congresos.index') }}"><i class="bi bi-person-walking"></i> Asistencia a Congresos</a></li>
                                @if(auth()->user()->esAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="bi bi-people-fill"></i> Usuarios</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link" type="submit"><i class="bi bi-box-arrow-right"></i> Salir</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Acceder</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO --}}
    <main class="container my-4">
        @if(session('ok'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('ok') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong>Revisa el formulario:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Botón regresar (oculto en la página de inicio) --}}
        @if(!request()->routeIs('inicio'))
            <button type="button" onclick="history.back()" class="btn btn-outline-primary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Regresar
            </button>
        @endif

        @yield('contenido')
    </main>

    <footer class="footer-itt py-4 mt-5">
        <div class="container text-center">
            <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> Tecomatlán, Puebla, México</p>
            <small>&copy; {{ date('Y') }} Instituto Tecnológico de Tecomatlán — Coordinación de Investigación</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>