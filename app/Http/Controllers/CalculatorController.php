<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    /**
     * Show the calculator page.
     */
    public function index(Request $request)
    {
        $calculations = Calculation::where('username', Auth::user()->username)
            ->orderBy('created_at', 'desc')
            ->limit(100) // Limit to 100 most recent records
            ->get();

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
            'username' => Auth::user()->username,
            'expression' => $validated['expression'],
            'result' => $validated['result'],
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get calculation history for the authenticated user.
     */
    public function history(Request $request)
    {
        $calculations = Calculation::where('username', Auth::user()->username)
            ->orderBy('created_at', 'desc')
            ->limit(100) // Limit to 100 most recent records
            ->get();

        return response()->json($calculations);
    }
}
