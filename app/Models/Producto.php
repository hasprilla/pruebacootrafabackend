<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id', // Quitamos 'id' ya que será autoincremental
        'name',
        'barcode',
        'price',
        'quantity'
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'inventory_id');
    }
}
