<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Genero;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Libro::with(['autor', 'genero']);

        if ($request->filled('search')) {
            $query->buscar($request->search);
        }

        if ($request->filled('genero_id')) {
            $query->where('genero_id', $request->genero_id);
        }

        if ($request->filled('disponible')) {
            $query->where('disponible', $request->disponible);
        }

        $libros = $query->latest()->paginate(12);
        $generos = Genero::orderBy('nombre')->get();

        return view('libros.index', compact('libros', 'generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $autores = Autor::orderBy('nombre')->get();
        $generos = Genero::orderBy('nombre')->get();
        return view('libros.create', compact('autores', 'generos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor_id' => 'required|exists:autores,id',
            'genero_id' => 'required|exists:generos,id',
            'anio_publicacion' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'required|string|unique:libros,isbn',
        ]);

        Libro::create($validated);

        return redirect()->route('libros.index')->with('success', 'Libro creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Libro $libro)
    {
        $libro->load(['autor', 'genero', 'prestamos.user']);
        return view('libros.show', compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro)
    {
        $autores = Autor::orderBy('nombre')->get();
        $generos = Genero::orderBy('nombre')->get();
        return view('libros.edit', compact('libro', 'autores', 'generos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor_id' => 'required|exists:autores,id',
            'genero_id' => 'required|exists:generos,id',
            'anio_publicacion' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'isbn' => 'required|string|unique:libros,isbn,' . $libro->id,
        ]);

        $libro->update($validated);

        return redirect()->route('libros.index')->with('success', 'Libro actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('success', 'Libro eliminado exitosamente.');
    }
}
