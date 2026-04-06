@extends('layouts.app')

@section('title', 'Editar Perfil - JODAXI')

@section('content')
<div style="grid-column: 1 / -1; max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h1>Editar Mi Perfil</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group">
                <label><strong>Foto de Perfil</strong></label>
                <div style="display: flex; gap: 1rem; align-items: flex-start; margin-top: 0.5rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: var(--border); display: flex; align-items: center; justify-content: center;">
                        @if(auth()->user()->foto_perfil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" 
                                alt="Foto perfil" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 2rem;"></span>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="foto_perfil" accept="image/*" 
                            style="display: block; margin-bottom: 0.5rem;">
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                            Máximo 2MB, JPG, PNG o GIF
                        </p>
                        @error('foto_perfil')
                            <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name"><strong>Nombre*</strong></label>
                <input type="text" id="name" name="name" 
                    value="{{ old('name', auth()->user()->name) }}"
                    placeholder="Tu nombre completo" required>
                @error('name')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email"><strong>Email</strong></label>
                <input type="email" id="email" value="{{ auth()->user()->email }}" 
                    disabled style="background: var(--border); cursor: not-allowed;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">
                    Contacta con soporte para cambiar tu email
                </p>
            </div>

            <div class="form-group">
                <label for="telefono"><strong>Teléfono</strong></label>
                <input type="tel" id="telefono" name="telefono" 
                    value="{{ old('telefono', auth()->user()->telefono) }}"
                    placeholder="Tu número de contacto">
                @error('telefono')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio"><strong>Biografía</strong></label>
                <textarea id="bio" name="bio" 
                    placeholder="Cuéntanos sobre ti..."
                    style="min-height: 100px; resize: vertical;">{{ old('bio', auth()->user()->bio) }}</textarea>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">
                    Máximo 500 caracteres
                </p>
                @error('bio')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <hr style="margin: 1.5rem 0; border: none; border-top: 1px solid var(--border);">

            <h3 style="margin-top: 1.5rem; margin-bottom: 1rem;">Cambiar Contraseña</h3>

            <div class="form-group">
                <label for="password"><strong>Nueva Contraseña</strong></label>
                <input type="password" id="password" name="password" 
                    placeholder="Déjalo en blanco si no deseas cambiar">
                @error('password')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation"><strong>Confirmar Contraseña</strong></label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    placeholder="Confirma tu nueva contraseña">
                @error('password_confirmation')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            @if($errors->any())
                <div style="background: #ffebee; border-left: 4px solid #d32f2f; padding: 1rem; border-radius: 0.4rem; margin-bottom: 1rem;">
                    <p style="margin: 0; color: #d32f2f; font-weight: 500;">Por favor revisa los errores arriba</p>
                </div>
            @endif

            <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-primary">Guardar Cambios</button>
                <a href="{{ route('user.profile', auth()->user()) }}" class="btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
