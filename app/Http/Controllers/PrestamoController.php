<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['user', 'libro.autor']);

        if (auth()->user()->isLector()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $prestamos = $query->latest()->paginate(15);

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $librosDisponibles = Libro::disponibles()->with('autor')->orderBy('titulo')->get();
        return view('prestamos.create', compact('librosDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'libro_id' => 'required|exists:libros,id',
            'fecha_devolucion' => 'required|date|after:today',
        ]);

        $libro = Libro::findOrFail($validated['libro_id']);

        if (!$libro->disponible) {
            return back()->withErrors(['libro_id' => 'Este libro no está disponible.'])->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['fecha_prestamo'] = now();
        $validated['estado'] = 'prestado';

        Prestamo::create($validated);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['user', 'libro.autor', 'libro.genero']);
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        return view('prestamos.edit', compact('prestamo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $validated = $request->validate([
            'estado' => 'required|in:prestado,devuelto,atrasado',
            'fecha_devolucion' => 'required|date',
        ]);

        $prestamo->update($validated);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado exitosamente.');
    }

    /**
     * Mark a loan as returned.
     */
    public function devolver(Prestamo $prestamo)
    {
        $prestamo->update(['estado' => 'devuelto']);

        return redirect()->route('prestamos.index')->with('success', 'Libro devuelto exitosamente.');
    }
}
