<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'JODAXI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg: #f1f8f1;
            --card: #ffffff;
            --primary: #4caf50;
            --primary-soft: #c8e6c9;
            --border: #e8f5e9;
            --text-main: #111827;
            --text-muted: #6b7280;
        }

        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; margin: 0; padding: 0; background: var(--bg); color: var(--text-main); }
        a { text-decoration: none; color: inherit; }

        header { background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%); color: white; padding: 0.75rem 1.5rem; position: sticky; top: 0; z-index: 10; }
        .header-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 0.5rem; }
        .logo-icon { width: 32px; height: 32px; border-radius: 0.75rem; background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%); display:flex; align-items:center; justify-content:center; font-weight:700; color:white; }
        .logo-title { font-size: 1.2rem; font-weight: 700; }
        .logo-sub { font-size: 0.75rem; color: #b8e6b8; }

        .header-links { display: flex; align-items: center; gap: 1rem; }
        .header-links a, .header-links button { font-size: 0.85rem; color: #b8e6b8; }
        .header-links a:hover, .header-links button:hover { color: white; }
        .user-info { font-size: 0.85rem; color: #c8e6c9; display: flex; align-items: center; gap: 1rem; }
        .btn-logout { background: #d32f2f; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem; transition: background 0.3s; font-weight: 500; }
        .btn-logout:hover { background: #b71c1c; }

        /* Menú desplegable */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-toggle { cursor: pointer; padding: 0.5rem; border-radius: 4px; transition: background 0.3s; }
        .dropdown-toggle:hover { background: rgba(255, 255, 255, 0.1); }
        .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; background: var(--card); border: 1px solid var(--border); border-radius: 4px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); min-width: 160px; z-index: 100; }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a { display: block; padding: 0.5rem 1rem; color: var(--text-main); text-decoration: none; }
        .dropdown-menu a:hover { background: var(--primary-soft); }

        main { max-width: 1200px; margin: 1.5rem auto; padding: 0 1rem; display: grid; grid-template-columns: 260px 1fr; gap: 1.5rem; }

        @media (max-width: 900px) {
            main { grid-template-columns: 1fr; }
        }

        .panel { background: var(--card); border-radius: 0.75rem; padding: 1rem; border: 1px solid var(--border); }
        .panel h2 { font-size: 1rem; margin: 0 0 0.75rem 0; }
        .panel small { color: var(--text-muted); }

        .filters-group { margin-top: 0.5rem; }
        .filters-group label { display:block; font-size:0.8rem; color:var(--text-muted); margin-bottom:0.25rem; }
        .filters-group select,
        .filters-group input { width:100%; padding:0.35rem 0.5rem; border-radius:0.4rem; border:1px solid var(--border); font-size:0.85rem; }

        .chips { display:flex; flex-wrap:wrap; gap:0.35rem; margin-top:0.35rem; }
        .chip { padding:0.15rem 0.55rem; border-radius:999px; border:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); background:#f9fafb; }

        .btn-primary { display:inline-flex; align-items:center; justify-content:center; padding:0.4rem 0.8rem; border-radius:999px; border:none; background:var(--primary); color:#fff; font-size:0.8rem; cursor:pointer; font-weight: 500; }
        .btn-primary:hover { background:#388e3c; box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }

        .btn-outline { display:inline-flex; align-items:center; justify-content:center; padding:0.35rem 0.7rem; border-radius:999px; border:1px solid var(--border); background:#fff; font-size:0.8rem; cursor:pointer; color:var(--text-muted); }
        .btn-outline:hover { background:#f3f4f6; }

        .cards-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem; }
        .cards-header h2 { margin:0; font-size:1.1rem; }
        .cards-header small { color:var(--text-muted); }

        .cards-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:0.9rem; }
        .card { background:var(--card); border-radius:0.75rem; border:1px solid var(--border); padding:0.6rem; display:flex; flex-direction:column; }
        .card-img { width:100%; height:140px; border-radius:0.5rem; background:#e5e7eb; margin-bottom:0.5rem; display:flex; align-items:center; justify-content:center; font-size:0.75rem; color:#9ca3af; object-fit: cover;}
        .card-title { font-size:0.95rem; font-weight:600; margin-bottom:0.15rem; }
        .card-price { font-weight:700; font-size:0.9rem; margin-bottom:0.15rem; }
        .card-meta { font-size:0.75rem; color:var(--text-muted); margin-bottom:0.15rem; }
        .card-footer { margin-top:auto; display:flex; justify-content:space-between; align-items:center; font-size:0.75rem; }

        .badge { display:inline-block; padding:0.15rem 0.45rem; border-radius:999px; font-size:0.72rem; font-weight:600; }
        .badge-venta { background:#fee2e2; color:#b91c1c; }
        .badge-compra { background:#dbeafe; color:#1d4ed8; }
        .badge-intercambio { background:#fef9c3; color:#854d0e; }
        .badge-donacion { background:#dcfce7; color:#166534; }

        .estado-disponible { color:#16a34a; }
        .estado-reservado { color:#92400e; }
        .estado-cerrado { color:#991b1b; }

        .empty { padding:1rem; text-align:center; color:var(--text-muted); font-size:0.9rem; background:var(--card); border-radius:0.75rem; border:1px solid var(--border); }

        .form-group { margin-bottom:0.5rem; }
        .form-group label { display:block; font-size:0.8rem; color:var(--text-muted); margin-bottom:0.15rem; }
        .form-group input,
        .form-group select,
        .form-group textarea { width:100%; padding:0.35rem 0.5rem; border-radius:0.4rem; border:1px solid var(--border); font-size:0.85rem; }
        .form-group textarea { resize:vertical; min-height:60px; }

        /* Páginación */
        .pagination { display: flex; gap: 0.5rem; align-items: center; justify-content: center; margin-top: 1.5rem; font-size: 0.9rem; }
        .pagination svg { width: 4px !important; height: 4px !important; }
        .pagination a svg, .pagination button svg { color: var(--primary); width: 4px !important; height: 4px !important; }
        .pagination .active svg { color: white; width: 4px !important; height: 4px !important; }
        .pagination button { padding: 0.25rem 0.4rem !important; }
        .pagination a { padding: 0.25rem 0.4rem !important; }

        /* Botón de Favoritos */
        .btn-favorite {
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-favorite:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background: white !important;
        }
        .btn-favorite:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
<header>
    <div class="header-inner">
        <div class="logo">
            <div class="logo-icon">JD</div>
            <div>
                <div class="logo-title">JODAXI</div>
                <div class="logo-sub">Tienda universitaria</div>
            </div>
        </div>
        <div class="header-links">
            <a href="{{ route('about') }}">Acerca de</a>
            @auth
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="dropdown">
                    <span class="dropdown-toggle">☰ Menú</span>
                    <div class="dropdown-menu">
                        <a href="{{ route('market.index') }}">Explorar</a>
                        <a href="{{ route('market.create') }}">Publicar</a>
                        <a href="{{ route('search') }}">Buscar</a>
                        <hr style="margin: 0.25rem 0; border: none; border-top: 1px solid var(--border);">
                        <a href="{{ route('messages.index') }}">Mensajes</a>
                        <a href="{{ route('favorites.index') }}">Favoritos</a>
                        <a href="{{ route('user.profile', auth()->user()) }}">Mi Perfil</a>
                        <a href="{{ route('profile.edit') }}">Editar Perfil</a>
                        @if(auth()->user()->is_admin)
                            <hr style="margin: 0.25rem 0; border: none; border-top: 1px solid var(--border);">
                            <a href="{{ route('report.admin') }}" style="color: #d32f2f;">Panel de Reportes</a>
                        @endif
                    </div>
                </div>
                <form action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('auth.login') }}">Iniciar Sesión</a>
                <a href="{{ route('auth.register') }}">Registrarse</a>
            @endauth
        </div>
        </div>
    </div>
</header>

<main>
    @include('partials.flash')
    @yield('content')
</main>

</body>
</html>