<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        //   productos vendidos en el periodo
        $productosVendidos = VentaDetalle::select(
            'productos.nombre as nombre_producto',
            'categorias.nombre as nombre_categoria',
            DB::raw('SUM(ventas_detalle.cantidad) as cantidad_total'),
            DB::raw('SUM(ventas_detalle.subtotal) as monto_total')
        )
            ->join('productos', 'ventas_detalle.producto_id', '=', 'productos.id')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->join('ventas', 'ventas_detalle.venta_id', '=', 'ventas.id')
            ->whereDate('ventas.created_at', '>=', $startDate)
            ->whereDate('ventas.created_at', '<=', $endDate)
            ->groupBy('productos.nombre', 'categorias.nombre')
            ->orderByDesc('cantidad_total')
            ->get();

        // top 3 productos mas vendidos
        $topProductos = VentaDetalle::select(
            'productos.nombre as nombre_producto',
            DB::raw('SUM(ventas_detalle.cantidad) as cantidad_total'),
            DB::raw('SUM(ventas_detalle.subtotal) as monto_total')
        )
            ->join('productos', 'ventas_detalle.producto_id', '=', 'productos.id')
            ->join('ventas', 'ventas_detalle.venta_id', '=', 'ventas.id')
            ->whereDate('ventas.created_at', '>=', $startDate)
            ->whereDate('ventas.created_at', '<=', $endDate)
            ->groupBy('productos.nombre')
            ->orderByDesc('cantidad_total')
            ->limit(3)
            ->get();

        //datos para la grafica de ventas por producto
        $chartData = VentaDetalle::select(
            'productos.nombre as nombre_producto',
            DB::raw('SUM(ventas_detalle.cantidad) as cantidad_total'),
            DB::raw('SUM(ventas_detalle.subtotal) as monto_total')
        )
            ->join('productos', 'ventas_detalle.producto_id', '=', 'productos.id')
            ->join('ventas', 'ventas_detalle.venta_id', '=', 'ventas.id')
            ->whereDate('ventas.created_at', '>=', $startDate)
            ->whereDate('ventas.created_at', '<=', $endDate)
            ->groupBy('productos.nombre')
            ->orderByDesc('cantidad_total')
            ->get();

        // totales generales
        $ventasTotales = Venta::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();


        $IngresosTotales = Venta::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total');

        return view('reportes.index', compact(
            'productosVendidos',
            'topProductos',
            'chartData',
            'ventasTotales',
            'IngresosTotales',
            'startDate',
            'endDate'
        ));

    }

}
