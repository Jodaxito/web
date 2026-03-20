<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - JODAXI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #d4f1d4 0%, #b8e6b8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #1a1a1a;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(76, 175, 80, 0.15);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
            color: white;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 0.5rem;
        }

        .logo-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2e7d32;
        }

        .logo-sub {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.25rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2e7d32;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #c8e6c9;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .error {
            color: #d32f2f;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .error-banner {
            background: #ffebee;
            border: 1px solid #ef5350;
            color: #c62828;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .links a {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .links a:hover {
            color: #2e7d32;
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 1rem 0;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">JD</div>
            <div class="logo-title">JODAXI</div>
            <div class="logo-sub">Tienda Universitaria</div>
        </div>

        <h2>Inicia Sesión</h2>

        @if($errors->any())
            <div class="error-banner">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('auth.login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="tu@email.com">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Inicia Sesión</button>
        </form>

        <div class="links">
            ¿No tienes cuenta? <a href="{{ route('auth.register') }}">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>
