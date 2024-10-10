<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany ;

class Producto extends Model
{
    
    protected $fillable = ['nombre', 'descripcion', 'precio_compra','precio_venta','stock'];
    public function ventas(): BelongsToMany
    {
        return $this->belongsToMany(Venta::class, 'venta_productos')
                    ->withPivot('cantidad', 'precio_venta')
                    ->withTimestamps();
    }

    
}