<?php

namespace App\Http\Controllers;

use App\Models\House; // Ensure this matches your Model namespace
use Illuminate\Http\Request;

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

        // If 'scout' is in the URL (e.g., ?scout=1), filter the results
        if ($request->has('scout')) {
            $query->where('scout_id', $request->scout);
        }

        $houses = $query->latest()->paginate(9);

        return view('houses.index', compact('houses'));
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