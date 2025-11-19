<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generos = Genero::withCount('libros')->latest()->paginate(15);
        return view('generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:generos,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        Genero::create($validated);

        return redirect()->route('generos.index')->with('success', 'Género creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genero $genero)
    {
        $genero->load('libros.autor');
        return view('generos.show', compact('genero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genero $genero)
    {
        return view('generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genero $genero)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:generos,nombre,' . $genero->id,
            'descripcion' => 'nullable|string|max:500',
        ]);

        $genero->update($validated);

        return redirect()->route('generos.index')->with('success', 'Género actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero)
    {
        $genero->delete();
        return redirect()->route('generos.index')->with('success', 'Género eliminado exitosamente.');
    }
}
