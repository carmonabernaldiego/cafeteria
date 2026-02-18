@extends('layouts.app')

@section('title', 'Nueva Categoría - Cafetería KFE')

@section('content')
    <div class="page-header">
        <h2 class="mb-0"><i class="bi bi-plus-circle text-muted"></i> Nueva Categoría</h2>
        <small class="text-muted">Agrega una nueva categoría de productos</small>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre de la Categoría</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required placeholder="Ej: Bebidas calientes, Postres...">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-kfe">
                        <i class="bi bi-check-lg"></i> Guardar Categoría
                    </button>
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
