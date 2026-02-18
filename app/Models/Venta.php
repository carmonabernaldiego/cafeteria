<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['total', 'nombre_cliente'];

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }
}
