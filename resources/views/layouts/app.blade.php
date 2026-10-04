<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EFAC - Estudios de Factibilidad</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f8fafc; }
        
        /*Sidebar style*/
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #1e293b; /* Color oscuro del mockup */
            color: #cbd5e1;
            position: fixed;
        }
        .sidebar-brand {
            padding: 1.5rem;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link {
            color: #cbd5e1;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
        }
        .nav-link:hover { color: white; }
        .nav-link.active {
            background-color: #2563eb; /* Azul del botón activo */
            color: white;
            border-radius: 0 25px 25px 0;
            margin-right: 15px;
        }
        
        /* Contenedor Principal */
        .main-content {
            margin-left: 260px;
            padding: 0;
        }
        
        /*Navbar*/
        .top-navbar {
            background-color: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-box {
            background-color: #f1f5f9;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            width: 300px;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <!-- BARRA LATERAL (SIDEBAR) -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-bar-chart-fill fs-3 text-primary"></i>
                <div>
                    <div class="m-0 lh-1">EFAC</div>
                    <small class="text-secondary" style="font-size: 0.7rem; font-weight:normal;">Estudios de Factibilidad</small>
                </div>
            </div>
            
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
    <!-- Le pusimos la ruta temporal al dashboard mientras haces la vista de 'Mis Estudios' -->
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('estudios.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Mis Estudios
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('auditoria.index') }}" class="nav-link {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-check"></i> Auditoría
                </a>
            </li>
                <li class="nav-item mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start text-danger">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                     </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="main-content flex-grow-1">
            <!-- BARRA SUPERIOR -->
            <div class="top-navbar">
                <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center bg-light rounded px-2">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" class="search-box bg-light" placeholder="Buscar estudios...">
                </form>
                <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle fs-4 text-secondary"></i>
                        <span class="fw-medium">{{ Auth::user()->name }} <small class="text-muted fw-normal">- {{ Auth::user()->rol }}</small></span>
                </div>
            </div>

            <!-- AQUÍ SE INYECTA LA VISTA DEL DASHBOARD -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>