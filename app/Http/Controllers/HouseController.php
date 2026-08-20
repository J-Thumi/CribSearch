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

    // 1. Location Filter (Matches the form's "location" input)
    if ($request->filled('location')) {
        $location = $request->input('location');
        $query->where(function ($q) use ($location) {
            $q->where('approximate_area', 'like', "%{$location}%")
              ->orWhere('nearest_gate', 'like', "%{$location}%")
              ->orWhere('name', 'like', "%{$location}%");
        });
    }

    // 2. Type/Size Filter (Matches the form's "type" select input)
    if ($request->filled('type')) {
        $type = $request->input('type');
        // Filters JSON array where any unit object has a matching "size"
        $query->whereJsonContains('units', [['size' => $type]]);
    }

    // 3. Max Price Filter (Matches units where at least one unit price <= max_price)
    if ($request->filled('max_price')) {
        $maxPrice = (float) $request->input('max_price');

        // Works on MySQL 5.7+ & MariaDB 10.2+ using JSON_TABLE or JSON_UNQUOTE
        $query->whereRaw("
            EXISTS (
                SELECT 1 
                FROM JSON_TABLE(units, '$[*]' COLUMNS (price FLOAT PATH '$.price')) AS u 
                WHERE u.price <= ?
            )
        ", [$maxPrice]);
    }

    // Legacy/Alternative query parameters (Retained for backwards compatibility)
    if ($request->filled('scout')) {
        $query->where('scout_id', $request->input('scout'));
    }

    if ($request->filled('gate')) {
        $query->where('nearest_gate', $request->input('gate'));
    }

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nearest_gate', 'like', "%{$search}%")
              ->orWhere('approximate_area', 'like', "%{$search}%");
        });
    }

    // Fetch paginated results and append search queries to pagination links
    $houses = $query->latest()->paginate(9)->withQueryString();

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