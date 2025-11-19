<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'category'])
                     ->where('stock', '>', 0)
                     ->paginate(12);
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::where('stock', '>', 0)->count(),
            'total_authors' => Author::count(),
            'active_loans' => Loan::where('estado', 'prestado')->count()
        ];
        return view('welcome', compact('books', 'stats'));
    }

    public function books()
    {
        $books = Book::with(['authors', 'category'])->get();
        return response()->json($books);
    }

    public function authors()
    {
        $authors = Author::with('books')->get();
        return response()->json($authors);
    }

    public function categories()
    {
        $categories = Category::with('books')->get();
        return response()->json($categories);
    }

    public function loans()
    {
        $loans = Loan::with(['user', 'book.authors'])->get();
        return response()->json($loans);
    }

    public function availableBooks()
    {
        $books = Book::where('stock', '>', 0)
                     ->with(['authors', 'category'])
                     ->get();
        return response()->json($books);
    }

    public function overdueLoans()
    {
        $overdueLoans = Loan::where('estado', 'prestado')
                           ->where('fecha_devolucion_esperada', '<', now())
                           ->with(['user', 'book.authors'])
                           ->get();
        return response()->json($overdueLoans);
    }
}
