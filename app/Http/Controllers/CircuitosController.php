<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Circuito;

class CircuitosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $circuitos = Circuito::all();
        return view('circuitos.index', compact('circuitos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('circuitos.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosCircuito=[
            'pais'=> $request->pais,
            'nombre'=> $request->nombre,
            'latitud1'=> $request->latitud1,
            'longitud1'=> $request->longitud1,
            'latitud2'=> $request->latitud2,
            'longitud2'=> $request->longitud2,
            'latitud3'=> $request->latitud3,
            'longitud3'=> $request->longitud3,
            'latitud4'=> $request->latitud4,
            'longitud4'=> $request->longitud4,
            'latitud5'=> $request->latitud5,
            'longitud5'=> $request->longitud5
        ];
        Circuito::create($datosCircuito);
        // Pasar mensaje a la vista con nombre 'message'
        return redirect()->route('circuitos.index')->with('message', 'Circuito creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
