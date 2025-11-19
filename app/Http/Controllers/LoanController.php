<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book.authors'])->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    /**
     * Mis préstamos del usuario logueado
     */
    public function myLoans()
    {
        $loans = Auth::user()->loans()->with('book.authors')->latest()->paginate(10);
        return view('loans.my-loans', compact('loans'));
    }

    /**
     * Prestar un libro
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        if ($book->stock <= 0) {
            return back()->with('error', 'No hay ejemplares disponibles de este libro.');
        }

        // Verificar si el usuario ya tiene este libro prestado
        $existingLoan = Loan::where('user_id', Auth::id())
                           ->where('book_id', $book->id)
                           ->where('estado', 'prestado')
                           ->exists();

        if ($existingLoan) {
            return back()->with('error', 'Ya tienes este libro prestado.');
        }

        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'fecha_prestamo' => now(),
            'fecha_devolucion_esperada' => now()->addDays(14),
            'estado' => 'prestado'
        ]);

        $book->decrement('stock');

        return back()->with('success', 'Libro prestado exitosamente.');
    }

    /**
     * Devolver un libro
     */
    public function returnBook(Loan $loan)
    {
        if ($loan->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para devolver este libro.');
        }

        if ($loan->estado !== 'prestado') {
            return back()->with('error', 'Este libro ya fue devuelto.');
        }

        $loan->update([
            'fecha_devolucion_real' => now(),
            'estado' => 'devuelto'
        ]);

        $loan->book->increment('stock');

        return back()->with('success', 'Libro devuelto exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $loan->load(['user', 'book.authors']);
        return view('loans.show', compact('loan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->estado === 'prestado') {
            $loan->book->increment('stock');
        }
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Préstamo eliminado exitosamente.');
    }
}
