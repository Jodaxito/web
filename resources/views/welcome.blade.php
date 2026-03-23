<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JODAXI - Marketplace Estudiantil</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --primary: #22c55e;
            --primary-dark: #16a34a;
            --secondary: #10b981;
            --bg: #f0fdf4;
            --text: #0f172a;
            --text-muted: #64748b;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }
        
        /* Header */
        header {
            background: linear-gradient(135deg, #0f766e 0%, #065f46 50%, #047857 100%);
            color: white;
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.12);
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
            text-decoration: none;
            color: white;
            transition: transform 0.3s ease;
        }
        
        .logo:hover { transform: translateY(-2px); }
        
        .logo-img {
            width: 52px;
            height: 52px;
            border-radius: 0.5rem;
            object-fit: contain;
            filter: brightness(1.1);
        }
        
        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #86efac 0%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }
        
        .logo-text p {
            font-size: 0.7rem;
            color: #a7f3d0;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin: 0;
        }
        
        .header-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .header-links a {
            color: #a7f3d0;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .header-links a:hover { color: white; }
        
        .btn-header {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-header:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 4rem 1.5rem;
            text-align: center;
            border-bottom: 3px solid var(--primary);
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h2 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 0.75rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(34, 197, 94, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary-dark);
            border: 2px solid var(--primary);
            padding: 0.9rem 1.9rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 0.75rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-left: 1rem;
        }
        
        .btn-secondary:hover {
            background: var(--primary-soft);
            transform: translateY(-3px);
        }
        
        /* Features */
        .features {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            border: 2px solid #d1fae5;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.08);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(34, 197, 94, 0.15);
            border-color: var(--primary);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--primary-dark);
        }
        
        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
        }
        
        /* Stats */
        .stats {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 3rem 1.5rem;
            margin: 2rem 0;
        }
        
        .stats-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }
        
        .stat-item h4 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }
        
        .stat-item p {
            font-size: 1rem;
            opacity: 0.95;
        }
        
        /* Call to Action */
        .cta {
            max-width: 800px;
            margin: 4rem auto;
            padding: 2rem;
            text-align: center;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.12);
        }
        
        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-dark);
        }
        
        .cta p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        /* Footer */
        footer {
            background: #0f766e;
            color: #a7f3d0;
            padding: 2rem 1.5rem;
            text-align: center;
            margin-top: 4rem;
        }
        
        footer p { margin: 0.5rem 0; }
        
        footer a {
            color: #86efac;
            text-decoration: none;
        }
        
        footer a:hover { color: white; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h2 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .btn-secondary { margin-left: 0; margin-top: 0.5rem; }
            .header-links { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-inner">
            <a href="{{ route('market.index') }}" class="logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="JODAXI Logo" class="logo-img">
                <div class="logo-text">
                    <h1>JODAXI</h1>
                    <p>MARKETPLACE ESTUDIANTIL</p>
                </div>
            </a>
            <div class="header-links">
                <a href="#features">Características</a>
                @auth
                    <a href="{{ route('market.index') }}" class="btn-header">Explorar</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-header" style="cursor: pointer;">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-header">Ingresar</a>
                    <a href="{{ route('register') }}" class="btn-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); border: none;">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>
    
    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h2>Bienvenido a JODAXI</h2>
            <p>La plataforma de compra, venta, intercambio y donación diseñada especialmente para la comunidad estudiantil</p>
            @auth
                <a href="{{ route('market.index') }}" class="btn-primary">Explorar Marketplace</a>
                <a href="{{ route('market.create') }}" class="btn-secondary">Publicar Ahora</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">Comenzar Ahora</a>
                <a href="{{ route('login') }}" class="btn-secondary">Iniciar Sesión</a>
            @endauth
        </div>
    </section>
    
    <!-- Features -->
    <section class="features" id="features">
        <div class="feature-card">
            <div class="feature-icon">🛍️</div>
            <h3>Compra & Venta</h3>
            <p>Encuentra productos a precios accesibles o vende tus artículos con facilidad a otros estudiantes</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">🔄</div>
            <h3>Intercambio</h3>
            <p>Intercambia artículos con otros estudiantes y consigue lo que necesitas sin gastar dinero</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">🎁</div>
            <h3>Donaciones</h3>
            <p>Dona artículos que ya no usas y ayuda a otros miembros de la comunidad</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">💬</div>
            <h3>Comunicación Segura</h3>
            <p>Mensajería integrada para negociar y cerrar tratos de forma segura</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3>Calificaciones</h3>
            <p>Sistema de reseñas para construir confianza en la comunidad estudiantil</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">❤️</div>
            <h3>Favoritos</h3>
            <p>Guarda tus anuncios favoritos y recibe notificaciones de nuevas publicaciones</p>
        </div>
    </section>
    
    <!-- Stats -->
    <section class="stats">
        <div class="stats-content">
            <div class="stat-item">
                <h4>500+</h4>
                <p>Usuarios Activos</p>
            </div>
            <div class="stat-item">
                <h4>2000+</h4>
                <p>Productos Listados</p>
            </div>
            <div class="stat-item">
                <h4>100%</h4>
                <p>Comunidad Segura</p>
            </div>
        </div>
    </section>
    
    <!-- CTA -->
    <div class="cta">
        <h2>¿Listo para comenzar?</h2>
        <p>Únete a miles de estudiantes que ya están comprando, vendiendo e intercambiando en JODAXI</p>
        @guest
            <a href="{{ route('register') }}" class="btn-primary">Crear Cuenta Ahora</a>
        @else
            <a href="{{ route('market.index') }}" class="btn-primary">Ver Marketplace</a>
        @endguest
    </div>
    
    <!-- Footer -->
    <footer>
        <p>&copy; 2026 JODAXI - Marketplace Estudiantil</p>
        <p>Diseñado con ❤️ para la comunidad estudiantil</p>
        <p><a href="{{ route('about') }}">Acerca de Nosotros</a> | 
        @auth
            <a href="{{ route('user.profile', auth()->user()) }}">Mi Perfil</a> | 
            <a href="{{ route('favorites.index') }}">Favoritos</a>
        @endauth
        </p>
    </footer>
</body>
</html>
