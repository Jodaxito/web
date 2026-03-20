@if(session('success'))
    <div style="background:#dcfce7; border:1px solid #bbf7d0; color:#166534; padding:0.5rem 0.75rem; border-radius:0.5rem; font-size:0.85rem; margin-bottom:0.5rem;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:0.5rem 0.75rem; border-radius:0.5rem; font-size:0.8rem; margin-bottom:0.5rem;">
        <strong>Revisa los campos:</strong>
        <ul style="margin:0.25rem 0 0 1rem; padding:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif