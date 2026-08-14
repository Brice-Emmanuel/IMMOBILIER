<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use Illuminate\Http\Request;

class BatimentController extends Controller
{
    public function index(Request $request)
    {
        $query = Batiment::where('user_id', auth()->id())
            ->withCount('logements'); // Charge le nombre de logements associés

        // 1. Recherche par nom, adresse ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('adresse', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Filtre par Ville
        if ($request->filled('ville')) {
            $query->where('ville', $request->ville);
        }

        // Conserve les filtres dans les liens de pagination
        $batiments = $query->latest()->paginate(10)->appends($request->query());

        // Récupère la liste distincte des villes de cet utilisateur pour le filtre déroulant
        $villes = Batiment::where('user_id', auth()->id())
            ->whereNotNull('ville')
            ->distinct()
            ->pluck('ville');

        return view('batiments.index', compact('batiments', 'villes'));
    }

    public function create()
    {
        return view('batiments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'adresse'     => 'required|string|max:255',
            'ville'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Batiment::create($validated);

        return redirect()->route('batiments.index')
            ->with('success', 'Bâtiment créé avec succès.');
    }

    public function show(Batiment $batiment)
    {
        $batiment->load(['logements', 'depenses']);
        return view('batiments.show', compact('batiment'));
    }

    public function edit(Batiment $batiment)
    {
        return view('batiments.edit', compact('batiment'));
    }

    public function update(Request $request, Batiment $batiment)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'adresse'     => 'required|string|max:255',
            'ville'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $batiment->update($validated);

        return redirect()->route('batiments.index')
            ->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function destroy(Batiment $batiment)
    {
        $batiment->delete();

        return redirect()->route('batiments.index')
            ->with('success', 'Bâtiment supprimé avec succès.');
    }
}