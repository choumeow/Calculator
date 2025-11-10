<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    /**
     * Show the calculator page.
     * Optimized: Don't load calculations on initial page load to speed up login.
     * Calculations will be loaded via AJAX after page loads.
     */
    public function index(Request $request)
    {
        // Don't load calculations on initial page load - load via AJAX instead
        // This significantly speeds up the login redirect
        $calculations = collect([]); // Empty collection for initial load

        return view('welcome', compact('calculations'));
    }

    /**
     * Store a calculation in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expression' => ['required', 'string'],
            'result' => ['required', 'string'],
        ]);

        Calculation::create([
            'user_id' => Auth::id(),
            'expression' => $validated['expression'],
            'result' => $validated['result'],
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get calculation history for the authenticated user.
     * Optimized: Only select necessary columns and use composite index.
     */
    public function history(Request $request)
    {
        $calculations = Calculation::where('user_id', Auth::id())
            ->select('id', 'expression', 'result', 'created_at') // Only select needed columns
            ->orderBy('created_at', 'desc')
            ->limit(100) // Limit to 100 most recent records
            ->get();

        return response()->json($calculations);
    }
}
