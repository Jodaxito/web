<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'JODAXI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg: #f0fdf4;
            --card: #ffffff;
            --primary: #22c55e;
            --primary-dark: #16a34a;
            --primary-light: #86efac;
            --primary-soft: #dcfce7;
            --secondary: #10b981;
            --accent: #06b6d4;
            --border: #d1fae5;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(34, 197, 94, 0.08);
            --shadow-lg: 0 8px 24px rgba(34, 197, 94, 0.12);
        }

        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: var(--bg); 
            color: var(--text-main); 
            line-height: 1.6;
        }
        a { text-decoration: none; color: inherit; }

        /* Header mejorado */
        header { 
            background: linear-gradient(135deg, #0f766e 0%, #065f46 50%, #047857 100%); 
            background-attachment: fixed;
            color: white; 
            padding: 1rem 1.5rem; 
            position: sticky; 
            top: 0; 
            z-index: 10;
            box-shadow: var(--shadow-lg);
        }
        .header-inner { 
            max-width: 1400px; 
            margin: 0 auto; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .logo { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem;
            transition: transform 0.3s ease;
        }
        .logo:hover { transform: translateY(-2px); }
        .logo-img { width: 48px; height: 48px; border-radius: 0.5rem; object-fit: contain; filter: brightness(1.1); }
        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }
        .logo-title { 
            font-size: 1.4rem; 
            font-weight: 800; 
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #86efac 0%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .logo-sub { 
            font-size: 0.7rem; 
            color: #a7f3d0;
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        .header-links { 
            display: flex; 
            align-items: center; 
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .header-links a, .header-links button { 
            font-size: 0.9rem; 
            color: #a7f3d0;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        .header-links a:hover, .header-links button:hover { 
            color: white;
        }
        .header-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-light);
            transition: width 0.3s ease;
        }
        .header-links a:hover::after {
            width: 100%;
        }
        .user-info { 
            font-size: 0.9rem; 
            color: #a7f3d0; 
            display: flex; 
            align-items: center; 
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .btn-logout { 
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white; 
            border: none; 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
            cursor: pointer; 
            font-size: 0.9rem; 
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }
        .btn-logout:hover { 
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Menú desplegable */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-toggle { 
            cursor: pointer; 
            padding: 0.5rem 0.75rem; 
            border-radius: 0.5rem; 
            transition: all 0.3s ease;
        }
        .dropdown-toggle:hover { background: rgba(255, 255, 255, 0.15); }
        .dropdown-menu { 
            display: none; 
            position: absolute; 
            top: 100%; 
            right: 0;
            background: var(--card); 
            border: 2px solid var(--border); 
            border-radius: 0.75rem; 
            box-shadow: var(--shadow-lg);
            min-width: 200px; 
            z-index: 100;
            animation: fadeIn 0.2s ease;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a { 
            display: block; 
            padding: 0.75rem 1rem; 
            color: var(--text-main); 
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .dropdown-menu a:hover { 
            background: var(--primary-soft);
            border-left-color: var(--primary);
            padding-left: 1.25rem;
        }

        main { 
            max-width: 1400px; 
            margin: 2rem auto; 
            padding: 0 1.5rem; 
            display: grid; 
            grid-template-columns: 300px 1fr; 
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            main { grid-template-columns: 260px 1fr; gap: 1.5rem; }
        }

        @media (max-width: 768px) {
            main { 
                grid-template-columns: 1fr; 
                margin: 1.5rem auto;
                padding: 0 1rem;
            }
        }

        .panel { 
            background: var(--card); 
            border-radius: 1rem; 
            padding: 1.5rem; 
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .panel:hover { box-shadow: var(--shadow-md); }
        .panel h2 { 
            font-size: 1.1rem; 
            margin: 0 0 0.5rem 0; 
            color: var(--primary-dark);
            font-weight: 700;
        }
        .panel small { 
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .filters-group { 
            margin-top: 1.2rem; 
            padding-top: 1.2rem;
            border-top: 1px solid var(--border);
        }
        .filters-group:first-child { border-top: none; margin-top: 0; padding-top: 0; }
        .filters-group label { 
            display: block; 
            font-size: 0.85rem; 
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .filters-group select,
        .filters-group input { 
            width: 100%; 
            padding: 0.6rem 0.75rem; 
            border-radius: 0.5rem; 
            border: 2px solid var(--border);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: var(--bg);
        }
        .filters-group select:focus,
        .filters-group input:focus { 
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        .chips { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 0.5rem; 
            margin-top: 0.5rem;
        }
        .chip { 
            padding: 0.4rem 0.9rem; 
            border-radius: 999px; 
            border: 2px solid var(--border); 
            font-size: 0.85rem; 
            color: var(--text-muted); 
            background: var(--bg);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .chip:hover { 
            border-color: var(--primary);
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .btn-primary { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            padding: 0.6rem 1.2rem; 
            border-radius: 0.75rem; 
            border: none; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white; 
            font-size: 0.9rem; 
            cursor: pointer; 
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-outline { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            padding: 0.5rem 1rem; 
            border-radius: 0.75rem; 
            border: 2px solid var(--border); 
            background: white; 
            font-size: 0.9rem; 
            cursor: pointer; 
            color: var(--text-muted);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline:hover { 
            background: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary-dark);
        }

        .cards-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .cards-header h2 { 
            margin: 0; 
            font-size: 1.5rem;
            color: var(--primary-dark);
            font-weight: 700;
        }
        .cards-header small { 
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .cards-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
            gap: 1.5rem;
        }
        .card { 
            background: var(--card); 
            border-radius: 1rem; 
            border: 1px solid var(--border); 
            padding: 0.75rem;
            display: flex; 
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            position: relative;
        }
        .card:hover { 
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .card:hover::before { opacity: 1; }
        
        .card-img { 
            width: 100%; 
            height: 160px; 
            border-radius: 0.75rem; 
            background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%);
            margin-bottom: 0.75rem; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 0.85rem; 
            color: var(--text-muted);
            object-fit: cover;
            position: relative;
            overflow: hidden;
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: var(--shadow-md);
        }
        .card-title { 
            font-size: 1rem; 
            font-weight: 700; 
            margin-bottom: 0.5rem;
            color: var(--text-main);
            line-height: 1.3;
        }
        .card-price { 
            font-weight: 800; 
            font-size: 1.1rem; 
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-meta { 
            font-size: 0.8rem; 
            color: var(--text-muted); 
            margin-bottom: 0.5rem;
        }
        .card-footer { 
            margin-top: auto; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            font-size: 0.8rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
        }

        .badge { 
            display: inline-block; 
            padding: 0.3rem 0.7rem; 
            border-radius: 999px; 
            font-size: 0.75rem; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .badge-venta { background: #fee2e2; color: #b91c1c; }
        .badge-compra { background: #dbeafe; color: #1d4ed8; }
        .badge-intercambio { background: #fef3c7; color: #92400e; }
        .badge-donacion { background: #dcfce7; color: #166534; }

        .estado-disponible { color: #22c55e; font-weight: 700; }
        .estado-reservado { color: #f97316; font-weight: 700; }
        .estado-cerrado { color: #ef4444; font-weight: 700; }

        .empty { 
            padding: 2rem; 
            text-align: center; 
            color: var(--text-muted); 
            font-size: 1rem; 
            background: var(--card); 
            border-radius: 1rem; 
            border: 2px dashed var(--border);
        }

        .form-group { margin-bottom: 1rem; }
        .form-group label { 
            display: block; 
            font-size: 0.9rem; 
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .form-group input,
        .form-group select,
        .form-group textarea { 
            width: 100%; 
            padding: 0.6rem 0.75rem; 
            border-radius: 0.5rem; 
            border: 2px solid var(--border); 
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: var(--bg);
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { 
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }
        .form-group textarea { resize: vertical; min-height: 100px; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        section {
            background: var(--card);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        /* Páginación */
        .pagination { display: flex; gap: 0.5rem; align-items: center; justify-content: center; margin-top: 1.5rem; font-size: 0.9rem; }
        .pagination svg { width: 4px !important; height: 4px !important; }
        .pagination a svg, .pagination button svg { color: var(--primary); width: 4px !important; height: 4px !important; }
        .pagination .active svg { color: white; width: 4px !important; height: 4px !important; }
        .pagination button { padding: 0.25rem 0.4rem !important; }
        .pagination a { padding: 0.25rem 0.4rem !important; }

        /* Animaciones */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        section { animation: slideInUp 0.5s ease-out; }
        .card { animation: scaleIn 0.3s ease-out; }

        /* Hover effects mejorados */
        a {
            transition: color 0.3s ease;
        }

        /* Links en texto */
        section a:not(.btn-primary):not(.btn-outline):not(.chip) {
            color: var(--primary);
            font-weight: 600;
        }

        section a:not(.btn-primary):not(.btn-outline):not(.chip):hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--secondary) 0%, var(--primary) 100%);
        }

        /* Print styles */
        @media print {
            header, .panel, .cards-header { display: none; }
            .cards-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        }

        /* Accesibilidad */
        .btn-primary:focus,
        .btn-outline:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Transiciones suaves */
        * {
            transition-duration: 0.3s;
            transition-timing-function: ease;
        }

        .btn-primary:active,
        .btn-outline:active {
            transition-duration: 0.1s;
        }

        /* Responsive media queries adicionales */
        @media (max-width: 640px) {
            .header-inner {
                flex-direction: column;
                gap: 1rem;
            }

            .cards-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 1rem;
            }

            .card {
                padding: 0.5rem;
            }

            .card-img {
                height: 140px;
            }

            .hero h2 {
                font-size: 2rem;
            }
        }

        /* Mejoras de accesibilidad para modo oscuro */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #1a1a1a;
                --card: #2d2d2d;
                --text: #e5e5e5;
                --text-muted: #a0a0a0;
            }

            body {
                background: var(--bg);
                color: var(--text);
            }

            .card, .panel, section {
                background: var(--card);
            }

            input, select, textarea {
                background: #1a1a1a;
                color: var(--text);
            }
        }
    </style>
</head>
<body>
<header>
    <div class="header-inner">
        <a href="{{ route('market.index') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit;">
            <div class="logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="JODAXI Logo" class="logo-img">
                <div class="logo-text">
                    <div class="logo-title">JODAXI</div>
                    <div class="logo-sub">Marketplace Estudiantil</div>
                </div>
            </div>
        </a>
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