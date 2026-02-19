@extends('layouts.app')

@section('title', 'Reportes - Cafetería KFE')


@section('content')
    <div class="page-header">
        <h2 class="mb-0"><i class="bi bi-bar-chart text-muted"></i> Reportes</h2>
        <small class="text-muted">Consulta las ventas y estadísticas de la cafetería</small>
    </div>



    <div class="card mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('reportes.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-bold">Fecha Inicio</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-bold">Fecha Fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-kfe w-100">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
            </form>

        </div>

    </div>


    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="stat-label">Total Ventas</div>
                <div class="stat-number">{{ $ventasTotales }}</div>
                <small class="text-muted">transacciones realizadas</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-3" style="border-left-color: var(--kfe-cafe);">
                <div class="stat-label">Ingresos Totales</div>
                <div class="stat-number">${{ number_format($IngresosTotales, 2) }}</div>
                <small class="text-muted">en el periodo seleccionado</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-3" style="border-left-color: #28a745;">
                <div class="stat-label">Productos Diferentes</div>
                <div class="stat-number">{{ $productosVendidos->count() }}</div>
                <small class="text-muted">productos vendidos</small>
            </div>
        </div>
    </div>

    <div class="row g-4">


        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0">Top 3 Productos Más Vendidos</h5>
                </div>
                <div class="card-body">
                    @forelse($topProductos as $index => $producto)
                        <div class="d-flex align-items-center mb-3 p-3 rounded {{ $index === 0 ? 'bg-warning bg-opacity-10' : 'bg-light' }}">
                            <div class="me-3">
                                @if($index === 0)
                                    <span class="badge bg-warning text-dark fs-5 rounded-circle p-2" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trophy-fill"></i>
                            </span>
                                @elseif($index === 1)
                                    <span class="badge bg-secondary fs-5 rounded-circle p-2" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                2
                            </span>
                                @else
                                    <span class="badge bg-dark fs-5 rounded-circle p-2" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                3
                            </span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $producto->nombre_producto }}</h6>
                                <small class="text-muted">{{ $producto->cantidad_total }} unidades vendidas</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-success">${{ number_format($producto->monto_total, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i>
                            <p class="mt-2">No hay datos para el periodo seleccionado</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0">Gráfica de Ventas por Producto</h5>
                </div>
                <div class="card-body">
                    @if($chartData->count() > 0)
                        <canvas id="salesChart" height="280"></canvas>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-bar-chart" style="font-size:3rem;"></i>
                            <p class="mt-2">No hay datos para graficar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">Productos Vendidos en el Periodo</h5>
            <small class="text-muted">Del {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th class="text-center">Cantidad Vendida</th>
                        <th class="text-end">Total Vendido</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($productosVendidos as $index => $producto)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $producto->nombre_producto }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $producto->nombre_categoria }}</span></td>
                            <td class="text-center">
                                <span class="badge badge-kfe">{{ $producto->cantidad_total }}</span>
                            </td>
                            <td class="text-end fw-bold">${{ number_format($producto->monto_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size:2rem;"></i>
                                <p class="mt-2">No hay ventas en el periodo seleccionado </p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    @if($productosVendidos->count() > 0)
                        <tfoot>
                        <tr class="table-dark">
                            <td colspan="3" class="fw-bold">TOTAL</td>
                            <td class="text-center fw-bold">{{ $productosVendidos->sum('cantidad_total') }}</td>
                            <td class="text-end fw-bold">${{ number_format($productosVendidos->sum('monto_total'), 2) }}</td>
                        </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            @if($chartData->count() > 0)
            const ctx = document.getElementById('salesChart').getContext('2d');

            const colors = [
                '#FF6F00', '#4E342E', '#FFB300', '#6D4C41', '#FF8F00',
                '#8D6E63', '#FFA726', '#5D4037', '#FFB74D', '#3E2723',
                '#FFCC80', '#795548', '#FFE0B2', '#A1887F', '#D7CCC8'
            ];

            const labels = @json($chartData->pluck('nombre_producto'));
            const quantities = @json($chartData->pluck('cantidad_total'));
            const amounts = @json($chartData->pluck('monto_total'));

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Cantidad Vendida',
                            data: quantities,
                            backgroundColor: colors.slice(0, labels.length).map(c => c + 'CC'),
                            borderColor: colors.slice(0, labels.length),
                            borderWidth: 2,
                            borderRadius: 6,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Monto ($)',
                            data: amounts,
                            type: 'line',
                            borderColor: '#FF6F00',
                            backgroundColor: 'rgba(255,111,0,0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#FF6F00',
                            pointRadius: 5,
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Cantidad'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Monto ($)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });
            @endif
        </script>
    @endpush
@endsection
