<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany ;
class Cliente extends Model
{         

    protected $fillable = ['nombre', 'direccion', 'telefono','email'];
    public function ventas(): HasMany

    {
        return $this->hasMany(Venta::class);
    }
}
