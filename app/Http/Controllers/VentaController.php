<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
    
        return view('ventas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'nullable|string|max:255',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $detallesData = [];

            foreach ($request->detalles as $detalle) {
                $producto = Producto::findOrFail($detalle['producto_id']);

                if ($producto->cantidad < $detalle['cantidad']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Cantidad insuficiente para {$producto->nombre}. Disponible: {$producto->cantidad}"
                    ], 422);
                }

                $subtotal = $producto->precio * $detalle['cantidad'];
                $total += $subtotal;

                $detallesData[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ];

                $producto->decrement('cantidad', $detalle['cantidad']);
            }

            $venta = Venta::create([
                'total' => $total,
                'nombre_cliente' => $request->nombre_cliente,
            ]);

            foreach ($detallesData as $detalleData) {
                $venta->detalles()->create($detalleData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada exitosamente.',
                'sale' => $sale->load('detallles.producto'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 500);
        }
    }
}
