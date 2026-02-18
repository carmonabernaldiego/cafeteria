@extends('layouts.app')

@section('title', 'Editar Categoría - Cafetería KFE')

@section('content')
    <div class="page-header">
        <h2 class="mb-0"><i class="bi bi-pencil-square text-muted"></i> Editar Categoría</h2>
        <small class="text-muted">Modifica la información de la categoría</small>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categorias.update', $categoria) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-kfe">
                        <i class="bi bi-check-lg"></i> Actualizar Categoría
                    </button>
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
