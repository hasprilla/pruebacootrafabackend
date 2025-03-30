<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $productos = Producto::with('inventario')->get();

        return response()->json([
            'success' => true,
            'data' => $productos,
            'message' => 'Lista de productos obtenida exitosamente.'
        ], 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inventory_id' => 'required|exists:inventarios,id',
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:productos,barcode',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Error en la validación de datos.'
            ], 422);
        }

        // No se incluye el ID en la creación, se genera automáticamente
        $producto = Producto::create([
            'inventory_id' => $request->inventory_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'data' => $producto->load('inventario'),
            'message' => 'Producto creado exitosamente.'
        ], 201);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $producto = Producto::with('inventario')->find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $producto,
            'message' => 'Producto obtenido exitosamente.'
        ], 200);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'inventory_id' => 'required|exists:inventarios,id',
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|unique:productos,barcode,' . $id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Error en la validación de datos.'
            ], 422);
        }

        $producto->update([
            'inventory_id' => $request->inventory_id,
            'name' => $request->name,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'data' => $producto->fresh('inventario'),
            'message' => 'Producto actualizado exitosamente.'
        ], 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ], 200);
    }
}
