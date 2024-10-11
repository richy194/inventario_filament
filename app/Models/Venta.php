<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venta extends Model


{

    use HasFactory;

    protected $fillable = ['cliente_id','fecha','total'];
    
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'venta_productos')
                    ->withPivot('cantidad', 'precio_venta')
                    ->withTimestamps();
    }


    public function getProductosListAttribute(): string
    {
        return $this->productos->pluck('nombre')->join(', ');
    }
}
