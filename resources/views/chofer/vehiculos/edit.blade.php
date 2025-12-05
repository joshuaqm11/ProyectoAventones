{{-- resources/views/chofer/vehiculos/edit.blade.php --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Vehículo</h4>
                </div>

                <div class="card-body">

                    {{-- ALERTA GENERAL DE ERRORES --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ocurrieron algunos errores:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('chofer.vehiculos.update', $vehiculo->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- PLACA -->
                        <div class="mb-3">
                            <label class="form-label">Placa</label>
                            <input type="text"
                                   name="placa"
                                   class="form-control @error('placa') is-invalid @enderror"
                                   value="{{ old('placa', $vehiculo->placa) }}"
                                   required
                                   maxlength="10"
                                   oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g,'');">
                            @error('placa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- MARCA -->
                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text"
                                   name="marca"
                                   class="form-control @error('marca') is-invalid @enderror"
                                   value="{{ old('marca', $vehiculo->marca) }}"
                                   required>
                            @error('marca')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- MODELO -->
                        <div class="mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text"
                                   name="modelo"
                                   class="form-control @error('modelo') is-invalid @enderror"
                                   value="{{ old('modelo', $vehiculo->modelo) }}"
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- AÑO -->
                        <div class="mb-3">
                            <label class="form-label">Año</label>
                            <input type="number"
                                   name="anio"
                                   class="form-control @error('anio') is-invalid @enderror"
                                   value="{{ old('anio', $vehiculo->anio) }}"
                                   required>
                            @error('anio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- COLOR -->
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="text"
                                   name="color"
                                   class="form-control @error('color') is-invalid @enderror"
                                   value="{{ old('color', $vehiculo->color) }}"
                                   required>
                            @error('color')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- CAPACIDAD -->
                        <div class="mb-3">
                            <label class="form-label">Capacidad</label>
                            <input type="number"
                                   name="capacidad"
                                   class="form-control @error('capacidad') is-invalid @enderror"
                                   value="{{ old('capacidad', $vehiculo->capacidad) }}"
                                   required>
                            @error('capacidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- FOTO -->
                        <div class="mb-3">
                            <label class="form-label">Fotografía (opcional)</label>
                            <input type="file"
                                   name="fotografia"
                                   class="form-control @error('fotografia') is-invalid @enderror">
                            @error('fotografia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- FOTO ACTUAL -->
                        @if($vehiculo->fotografia)
                            <div class="mb-3 text-center">
                                <p class="fw-bold">Fotografía actual:</p>
                                <img src="{{ asset('storage/' . $vehiculo->fotografia) }}" 
                                     class="img-fluid rounded"
                                     style="max-height: 200px;">
                            </div>
                        @endif

                        <!-- BOTÓN -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                Actualizar Vehículo
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
