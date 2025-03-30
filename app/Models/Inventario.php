<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function productos()
    {
        return $this->hasMany(Producto::class, 'inventory_id');
    }
}
