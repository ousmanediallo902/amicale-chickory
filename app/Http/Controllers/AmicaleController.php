<?php

namespace App\Http\Controllers;

use App\Models\Amicale;
use Illuminate\Http\Request;

class AmicaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amicales = Amicale::withCount('etudiants')->orderBy('nom')->get();
        return view('amicales.index', compact('amicales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('amicales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'nom.required' => "Le nom de l'amicale est obligatoire",
        ]);

        Amicale::create($validated);

        return redirect()->route('amicales.index')
            ->with('success', "Maison / Amicale créée avec succès");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amicale $amicale)
    {
        return view('amicales.edit', compact('amicale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amicale $amicale)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'nom.required' => "Le nom de l'amicale est obligatoire",
        ]);

        $amicale->update($validated);

        return redirect()->route('amicales.index')
            ->with('success', "Maison / Amicale modifiée avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amicale $amicale)
    {
        $amicale->delete();

        return redirect()->route('amicales.index')
            ->with('success', "Maison / Amicale supprimée avec succès");
    }
}
