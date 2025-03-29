<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'inventory_id');
    }
}
