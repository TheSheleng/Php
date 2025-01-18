<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movies', compact('movies'));
    }
  
    public function movieCart()
    {
        return view('cart');
    }

    public function addMovieToCart(Request $request)
    {
        $movieId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $cartItemId = $request->input('cart_item_id');

        $movie = Movie::find($movieId);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$movieId])) {
            // Update quantity if product is already in the cart
            $cart[$movieId]['quantity'] += $quantity;
        } else {
            // Add new item to the cart
            $cart[$movieId] = [
                'id' => $movie->id,
                'name' => $movie->name,
                'price' => $movie->price,
                'quantity' => $quantity,
                "poster" => $movie->poster
            ];
        }

        session()->put('cart', $cart);

        // Calculate the total quantity
        $totalQuantity = 0;
        foreach ($cart as $item) {
            $totalQuantity += $item['quantity'];
        }
        return response()->json(['message' => 'Cart updated', 'cartCount' => $totalQuantity], 200);
    }

    public function deleteItem(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Movie successfully deleted.');
        }
    }

    // Метод для поиска фильмов
    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = Movie::where('name', 'LIKE', "%{$query}%")->get();

        return view('movies.search', compact('movies'));
    }

    // Display the form to create a new movie
    public function create()
    {
        // Метод возвращает страницу формы создания фильма
        return view('movies.create');
    }

    // Store the new movie in the database
    public function store(Request $request)
    {
        // Метод обрабатывает данные формы и сохраняет фильм в базе
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255', 
            'poster' => 'required|url', 
            'price' => 'required|numeric|min:0', 
        ]);        

        Movie::create($validated);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully.');
    }
}

