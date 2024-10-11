<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{ 




    protected $fillable = ['nombre', 'direccion', 'telefono','email'];
    public function compras(): HasMany
    {
        return $this->HasMany(Compra::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->BelongsToMany(Producto::class, 'proveedor_productos')
                    ->withTimestamps();
    }
}