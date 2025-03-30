<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function index()
    {
        $productos = Producto::with('inventario')->get();
        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:productos',
            'inventory_id' => 'required|exists:inventarios,id',
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:productos',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $producto = Producto::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $producto,
            'message' => 'Producto creado exitosamente.'
        ], 201);
    }


    public function show(Producto $producto)
    {
        return response()->json([
            'success' => true,
            'data' => $producto->load('inventario')
        ]);
    }


    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventarios,id',
            'name' => 'required|string|max:255',
            'barcode' => 'required|string' . $producto->id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $producto->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $producto,
            'message' => 'Producto actualizado exitosamente.'
        ]);
    }


    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ]);
    }
}
