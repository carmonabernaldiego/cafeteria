@extends('layouts.app')


@section('title', 'Productos - Cafetería KFE')


@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0"><i class="bi bi-box-seam text-muted"></i> Administración de Productos</h2>
            <small class="text-muted">Gestiona el catálogo de productos de la cafetería</small>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-kfe">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
    </div>


    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>
                                    @if ($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                            class="rounded" style="width:45px;height:45px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width:45px;height:45px;">
                                            <i class="bi bi-cup-hot text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $producto->nombre }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $producto->categoria->nombre }}</span></td>
                                <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                                <td>
                                    @if ($producto->cantidad <= 5)
                                        <span class="badge bg-danger">{{ $producto->cantidad }}</span>
                                    @elseif($producto->cantidad <= 15)
                                        <span class="badge bg-warning text-dark">{{ $producto->cantidad }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $producto->cantidad }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($producto->activo)
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Activo</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('productos.edit', $producto) }}"
                                        class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
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
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size:2rem;"></i>
                                    <p class="mt-2">No hay productos registrados.</p>
                                    <a href="{{ route('productos.create') }}" class="btn btn-sm btn-kfe">Agregar primer
                                        producto</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $productos->links() }}
    </div>
@endsection
