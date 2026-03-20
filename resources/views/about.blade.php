@extends('layouts.app')

@section('title', 'Acerca de JODAXI')

@section('content')
<div class="about-container">
    <!-- Sección de Acerca del Proyecto -->
    <div class="about-project panel">
        <h1 class="about-title">Acerca de JODAXI</h1>
        <p class="about-description">
            JODAXI es una plataforma de compraventa y trueque diseñada especialmente para la comunidad universitaria. 
            Nuestro objetivo es facilitar el intercambio de productos, servicios y recursos entre estudiantes, 
            profesores y personal de la universidad de manera segura, confiable y eficiente.
        </p>
        
        <div class="about-features">
            <h2>¿Por qué JODAXI?</h2>
            <ul>
                <li><strong>Comunidad Universitaria:</strong> Conecta a estudiantes y profesores en un único espacio</li>
                <li><strong>Múltiples Opciones:</strong> Compra, venta, trueque o donación de productos</li>
                <li><strong>Seguridad:</strong> Plataforma confiable y verificada para transacciones</li>
                <li><strong>Facilidad de Uso:</strong> Interfaz intuitiva y amigable para todos</li>
                <li><strong>Sostenibilidad:</strong> Promueve la reutilización y el comercio responsable</li>
            </ul>
        </div>
    </div>

    <!-- Sección de Creadores -->
    <div class="creators-section">
        <h2 class="section-title">Nuestro Equipo de Desarrollo</h2>
        <p class="section-subtitle">Conoce a los desarrolladores que hicieron posible JODAXI</p>

        <div class="creators-grid">
            <!-- Creador 1 -->
            <div class="creator-card panel">
                <div class="creator-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
                        <circle cx="50" cy="50" r="50" fill="#4caf50"/>
                        <circle cx="50" cy="35" r="15" fill="white"/>
                        <path d="M 20 75 Q 50 60 80 75 L 80 100 Q 50 85 20 100 Z" fill="white"/>
                    </svg>
                </div>
                <h3 class="creator-name">Desarrollador 1</h3>
                <p class="creator-role">Desarrollador Full Stack</p>
                <p class="creator-description">
                    Especialista en backend y base de datos. Responsable de la arquitectura del sistema, 
                    implementación de APIs y optimización de la plataforma.
                </p>
                <div class="creator-skills">
                    <span class="skill">Laravel</span>
                    <span class="skill">PHP</span>
                    <span class="skill">MySQL</span>
                </div>
            </div>

            <!-- Creador 2 -->
            <div class="creator-card panel">
                <div class="creator-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
                        <circle cx="50" cy="50" r="50" fill="#2e7d32"/>
                        <circle cx="50" cy="35" r="15" fill="white"/>
                        <path d="M 20 75 Q 50 60 80 75 L 80 100 Q 50 85 20 100 Z" fill="white"/>
                    </svg>
                </div>
                <h3 class="creator-name">Desarrollador 2</h3>
                <p class="creator-role">Desarrollador Frontend</p>
                <p class="creator-description">
                    Experto en interfaz de usuario y experiencia del cliente. Diseñó y desarrolló el frontend 
                    responsable, asegurando que JODAXI sea intuitiva y atractiva.
                </p>
                <div class="creator-skills">
                    <span class="skill">Blade</span>
                    <span class="skill">CSS</span>
                    <span class="skill">JavaScript</span>
                </div>
            </div>

            <!-- Creador 3 -->
            <div class="creator-card panel">
                <div class="creator-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">
                        <circle cx="50" cy="50" r="50" fill="#1b5e20"/>
                        <circle cx="50" cy="35" r="15" fill="white"/>
                        <path d="M 20 75 Q 50 60 80 75 L 80 100 Q 50 85 20 100 Z" fill="white"/>
                    </svg>
                </div>
                <h3 class="creator-name">Desarrollador 3</h3>
                <p class="creator-role">Developer & DevOps</p>
                <p class="creator-description">
                    Ingeniero de infraestructura y desarrollo. Gestiona el despliegue, mantenimiento y 
                    asegura la estabilidad y seguridad de la plataforma JODAXI.
                </p>
                <div class="creator-skills">
                    <span class="skill">Servidor</span>
                    <span class="skill">Base Datos</span>
                    <span class="skill">Seguridad</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Contacto -->
    <div class="contact-section panel">
        <h2>¿Preguntas o Sugerencias?</h2>
        <p>
            Si tienes preguntas, sugerencias o reportes de problemas, no dudes en ponerte en contacto con nosotros. 
            Tu retroalimentación es valiosa para mejorar JODAXI.
        </p>
        <p><strong>Email:</strong> contacto@jodaxi.edu</p>
        <p><strong>Soporte:</strong> soporte@jodaxi.edu</p>
    </div>
</div>

<style>
    .about-container {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .about-project {
        background: linear-gradient(135deg, #f1f8f1 0%, #e8f5e9 100%);
        padding: 2.5rem !important;
    }

    .about-title {
        font-size: 2.5rem;
        margin: 0 0 1rem 0;
        color: #1b5e20;
    }

    .about-description {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #2e7d32;
        margin-bottom: 2rem;
    }

    .about-features h2 {
        font-size: 1.5rem;
        color: #2e7d32;
        margin: 1.5rem 0 1rem 0;
    }

    .about-features ul {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .about-features li {
        background: white;
        padding: 1rem;
        border-radius: 0.5rem;
        border-left: 4px solid #4caf50;
        line-height: 1.6;
    }

    .section-title {
        font-size: 2rem;
        color: #1b5e20;
        margin: 0 0 0.5rem 0;
        text-align: center;
    }

    .section-subtitle {
        color: #6b7280;
        text-align: center;
        font-size: 1rem;
        margin: 0 0 2rem 0;
    }

    .creators-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .creator-card {
        text-align: center;
        padding: 2rem 1.5rem !important;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 2px solid #e8f5e9 !important;
    }

    .creator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(76, 175, 80, 0.15);
    }

    .creator-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .creator-avatar svg {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    .creator-name {
        font-size: 1.3rem;
        margin: 1rem 0 0.5rem 0;
        color: #1b5e20;
    }

    .creator-role {
        color: #4caf50;
        font-weight: 600;
        font-size: 0.95rem;
        margin: 0 0 1rem 0;
    }

    .creator-description {
        color: #6b7280;
        line-height: 1.6;
        font-size: 0.95rem;
        margin: 0 0 1.5rem 0;
    }

    .creator-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }

    .skill {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .contact-section {
        text-align: center;
        background: linear-gradient(135deg, #f1f8f1 0%, #e8f5e9 100%);
        padding: 2rem !important;
    }

    .contact-section h2 {
        color: #1b5e20;
        margin: 0 0 1rem 0;
    }

    .contact-section p {
        margin: 0.5rem 0;
        color: #2e7d32;
    }

    @media (max-width: 900px) {
        .about-title {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .creators-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
