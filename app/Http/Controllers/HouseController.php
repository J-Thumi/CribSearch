<?php

namespace App\Http\Controllers;

use App\Models\House; // Ensure this matches your Model namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HouseController extends Controller
{
    /**
     * Display a listing of the houses.
     */
    // public function index()
    // {
    //     // Get houses with their units, paginated for better performance
    //     $houses = House::latest()->paginate(9);

    //     return view('houses.index', compact('houses'));
    // }


    
  public function index(Request $request)
{
    $query = House::with('scout');

    // Filter by Scout ID
    if ($request->filled('scout')) {
        $query->where('scout_id', $request->input('scout'));
    }

    // Filter by Nearest Campus Gate (Exact or Partial Search)
    if ($request->filled('gate')) {
        $query->where('nearest_gate', $request->input('gate'));
    }

    // Filter by Unit Size inside JSON units array
    if ($request->filled('size')) {
        $size = $request->input('size');
        // Native Laravel JSON check for array of objects with key "size"
        $query->whereJsonContains('units', [['size' => $size]]);
    }

    // Filter by Max Price inside JSON units array
    if ($request->filled('max_price')) {
        $maxPrice = (float) $request->input('max_price');
        $query->whereRaw("JSON_SEARCH(JSON_EXTRACT(units, '$[*].price'), 'one', ?, NULL, '$[*]') IS NOT NULL", [$maxPrice]);
    }

    // General Search (Name, Location, Gate)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nearest_gate', 'like', "%{$search}%")
              ->orWhere('approximate_area', 'like', "%{$search}%");
        });
    }

    // Get houses paginated
    $houses = $query->latest()->paginate(9)->withQueryString();

    // Fetch distinct non-null gates for dynamic select dropdown in the blade view
    $gates = House::whereNotNull('nearest_gate')
        ->distinct()
        ->pluck('nearest_gate');

    return view('houses.index', compact('houses', 'gates'));
}

    /**
     * Display the specified house details.
     */
    public function show($id)
    {
        $house = House::findOrFail($id);

        // Optional: SEO or page title logic
        $pageTitle = $house->name . " - Property Details";

        return view('houses.show', compact('house', 'pageTitle'));
    }
}