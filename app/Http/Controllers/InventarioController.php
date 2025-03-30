<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventarios = Inventario::all();
        return response()->json([
            'status' => 'success',
            'data' => $inventarios
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // No se incluye 'id' en la validación
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $inventario = Inventario::create([
            'name' => $request->name
            // No se asigna 'id' manualmente
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $inventario
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $inventario
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            // No se valida el 'id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $inventario->update([
            'name' => $request->name
            // No se actualiza el 'id'
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $inventario
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventario = Inventario::find($id);

        if (!$inventario) {
            return response()->json([
                'status' => 'error',
                'message' => 'Inventario no encontrado'
            ], 404);
        }

        $inventario->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Inventario eliminado correctamente'
        ], 200);
    }
}
