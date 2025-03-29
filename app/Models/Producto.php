<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'inventory_id',
        'name',
        'barcode',
        'price',
        'quantity'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'inventory_id');
    }
}
