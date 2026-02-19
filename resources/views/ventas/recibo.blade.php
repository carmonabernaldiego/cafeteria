@extends('layouts.app')

@section('title', 'Recibo - Cafetería KFE')

@push('styles')
    <style>
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, var(--kfe-cafe), var(--kfe-cafe-claro));
            color: white;
            text-align: center;
            padding: 1.5rem;
        }

        .receipt-body {
            padding: 1.5rem;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #ddd;
        }

        .receipt-total {
            background: var(--kfe-crema);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--kfe-cafe);
        }

        .receipt-footer {
            text-align: center;
            padding: 1rem;
            color: #999;
            font-size: 0.85rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .receipt {
                box-shadow: none;
            }

            body {
                background: white;
            }

            .navbar,
            footer {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="text-center mb-3 no-print">
        <button onclick="window.print()" class="btn btn-kfe">
            <i class="bi bi-printer"></i> Imprimir Recibo
        </button>
        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Ventas
        </a>
    </div>

    <div class="receipt">
        <div class="receipt-header">
            <h3 class="mb-1"><i class="bi bi-cup-hot-fill"></i> Cafetería KFE</h3>
            <small>Recibo de Venta</small>
        </div>
        <div class="receipt-body">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Recibo #:</span>
                <strong>{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Fecha:</span>
                <strong>{{ $venta->created_at->format('d/m/Y H:i') }}</strong>
            </div>
            @if ($venta->nombre_cliente)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Cliente:</span>
                    <strong>{{ $venta->nombre_cliente }}</strong>
                </div>
            @endif
            <hr>
            @foreach ($venta->detalles as $detalle)
                <div class="receipt-item">
                    <div>
                        <div class="fw-bold">{{ $detalle->producto->nombre }}</div>
                        <small class="text-muted">{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 2) }}</small>
                    </div>
                    <div class="fw-bold">${{ number_format($detalle->subtotal, 2) }}</div>
                </div>
            @endforeach
        </div>
        <div class="receipt-total">
            <span>TOTAL</span>
            <span>${{ number_format($venta->total, 2) }}</span>
        </div>
        <div class="receipt-footer">
            <p class="mb-1">Gracias por su compra</p>
            <small>Cafetería KFE - {{ date('Y') }}</small>
        </div>
    </div>
@endsection
