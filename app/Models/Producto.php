<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'cantidad', 'imagen', 'categoria_id', 'activo'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
