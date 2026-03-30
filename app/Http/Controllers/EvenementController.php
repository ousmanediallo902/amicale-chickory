<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenements = Evenement::orderByDesc('date')->get();

        return view('evenements.index', compact('evenements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('evenements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'lieu' => 'nullable|string|max:255',
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'date.required' => 'La date est obligatoire',
        ]);

        Evenement::create($validated);

        return redirect()->route('evenements.index')
            ->with('success', 'Événement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement)
    {
        return view('evenements.edit', compact('evenement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evenement $evenement)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'lieu' => 'nullable|string|max:255',
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'date.required' => 'La date est obligatoire',
        ]);

        $evenement->update($validated);

        return redirect()->route('evenements.index')
            ->with('success', 'Événement modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evenement $evenement)
    {
        $evenement->delete();

        return redirect()->route('evenements.index')
            ->with('success', 'Événement supprimé avec succès');
    }
}
