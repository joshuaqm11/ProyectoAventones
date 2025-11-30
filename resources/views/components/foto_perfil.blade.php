<div class="text-center mb-3">
    <div style="
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #007bff;
        margin: auto;
        box-shadow: 0 0 8px rgba(0,0,0,0.15);
    ">
        @if(auth()->user()->foto)
            <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                 alt="Foto de perfil"
                 style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                 alt="Foto genérica"
                 style="width: 100%; height: 100%; object-fit: cover;">
        @endif
    </div>

    <p class="mt-2 fw-bold mb-0">
        {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
    </p>
    <p class="text-muted small">{{ ucfirst(auth()->user()->tipo) }}</p>
</div>
