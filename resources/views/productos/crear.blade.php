@extends('layouts.app')


@section('title', 'Crear Producto - Cafetería KFE')

@section('content')
    <div class="page-header">
        <h2><i class="bi bi-plus-lg text-muted"></i> Crear Nuevo Producto</h2>
        <small class="text-muted">Agrega un nuevo producto al catálogo de la cafetería</small>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre del Producto</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                            name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="categoria_id" class="form-label fw-bold">Categoría</label>
                        <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id"
                            name="categoria_id" required>
                            <option value="">Seleccionar categoría...</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-bold">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                        rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="precio" class="form-label fw-bold">Precio ($)</label>
                        <input type="number" step="0.01" min="0"
                            class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio"
                            value="{{ old('precio') }}" required>
                        @error('precio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cantidad" class="form-label fw-bold">cantidad</label>
                        <input type="number" min="0" class="form-control @error('cantidad') is-invalid @enderror"
                            id="cantidad" name="cantidad" value="{{ old('cantidad', 0) }}" required>
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="imagen" class="form-label fw-bold">Imagen</label>
                        <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen"
                            name="imagen" accept="image/*">
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1"
                            {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="activo">Producto Activo</label>
                    </div>
                </div>

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-kfe">
                        <i class="bi bi-check-lg"></i> Guardar Producto
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
