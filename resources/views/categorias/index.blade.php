@extends('layouts.app')

@section('title', 'Categorías - Cafetería KFE')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0"><i class="bi bi-tags text-muted"></i> Administración de Categorías</h2>
            <small class="text-muted">Gestionar las categorías de los productos</small>
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-kfe">
            <i class="bi bi-plus-lg"></i> Nueva Categoría
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Productos</th>
                            <th>Creada</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td><strong>{{ $categoria->nombre }}</strong></td>
                                <td><span class="badge bg-info">{{ $categoria->productos_count }} productos</span></td>
                                <td>{{ $categoria->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                        class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro? Se eliminarán también los productos asociados.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size:2rem;"></i>
                                    <p class="mt-2">No hay categorías registradas.</p>
                                    <a href="{{ route('categorias.create') }}" class="btn btn-sm btn-kfe">Agregar primera
                                        categoría</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $categorias->links() }}
    </div>
@endsection
