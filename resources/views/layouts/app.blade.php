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

        /* Notificaciones y badges mejorados */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.4rem;
            border-radius: 999px;
            min-width: 18px;
            text-align: center;
        }

        /* Dropdown mejorado */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .dropdown-toggle svg {
            transition: transform 0.3s ease;
        }
        
        .dropdown:hover .dropdown-toggle svg {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--card);
            border: 2px solid var(--border);
            border-radius: 1rem;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            z-index: 100;
            animation: fadeIn 0.2s ease;
            margin-top: 0.5rem;
            padding: 0.5rem;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-main);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .dropdown-menu a:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding-left: 1.25rem;
        }

        .dropdown-menu a svg {
            width: 18px;
            height: 18px;
            color: var(--text-muted);
        }

        .dropdown-menu a:hover svg {
            color: var(--primary);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 0.5rem 0;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }

        /* Animación para notificaciones toast */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Estilos para botones de acción del header */
        .header-action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .header-action-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Link de Favoritos en el menú */
        .menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-main);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .menu-link:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .menu-link svg {
            width: 18px;
            height: 18px;
            color: var(--text-muted);
        }

        .menu-link:hover svg {
            color: var(--primary);
        }

        .menu-link.danger {
            color: #dc2626;
        }

        .menu-link.danger:hover {
            background: #fee2e2;
        }

        .menu-link.danger svg {
            color: #dc2626;
        }

        /* User avatar en header */
        .header-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .header-user-avatar-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #86efac 0%, #6ee7b7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #065f46;
            font-weight: 700;
            font-size: 1rem;
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
            <a href="{{ route('about') }}" class="header-action-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                Acerca de
            </a>
            @auth
                <a href="{{ route('favorites.index') }}" class="header-action-btn" style="position: relative;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    Favoritos
                    @if(auth()->user()->favoritos()->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->favoritos()->count() }}</span>
                    @endif
                </a>
                <a href="{{ route('messages.index') }}" class="header-action-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Mensajes
                </a>
                <div class="dropdown">
                    <span class="dropdown-toggle">
                        @if(auth()->user()->foto_perfil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" class="header-user-avatar" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="header-user-avatar-placeholder">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        {{ auth()->user()->name }}
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </span>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">Cuenta</div>
                        <a href="{{ route('market.index') }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Inicio
                        </a>
                        <a href="{{ route('market.create') }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Nueva Publicación
                        </a>
                        <a href="{{ route('search') }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            Buscar
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">Mi Perfil</div>
                        <a href="{{ route('user.profile', auth()->user()) }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Ver Perfil
                        </a>
                        <a href="{{ route('profile.edit') }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Editar Perfil
                        </a>
                        <a href="{{ route('favorites.index') }}" class="menu-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                            Mis Favoritos
                        </a>
                        
                        @if(auth()->user()->is_admin)
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header">Administración</div>
                            <a href="{{ route('report.admin') }}" class="menu-link danger">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                Panel de Reportes
                            </a>
                        @endif
                        
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-link danger" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('auth.login') }}" class="btn-outline" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.3); color: white;">
                    Iniciar Sesión
                </a>
                <a href="{{ route('auth.register') }}" class="btn-primary">
                    Registrarse
                </a>
            @endauth
        </div>
    </div>
</header>

<main>
    @include('partials.flash')
    @yield('content')
</main>

</body>
</html>