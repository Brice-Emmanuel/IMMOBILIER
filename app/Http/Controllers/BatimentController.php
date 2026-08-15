<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use Illuminate\Http\Request;

class BatimentController extends Controller
{
    public function index(Request $request)
    {
        // Début de la requête pour l'utilisateur connecté
        $query = Batiment::where('user_id', auth()->id())
            ->withCount('logements');

        // 🔍 Filtre par nom ou adresse
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('adresse', 'like', "%{$search}%");
            });
        }

        // 🏙️ Filtre par ville
        if ($request->filled('ville')) {
            $query->where('ville', $request->input('ville'));
        }

        // 🔃 Tri / Ordre d'affichage
        if ($request->input('sort') === 'asc') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // Récupération des résultats
        $batiments = $query->paginate(9)->withQueryString();

        // Liste des villes pour le filtre
        $villes = Batiment::where('user_id', auth()->id())
            ->whereNotNull('ville')
            ->where('ville', '!=', '')
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
            'name' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:500',
            'ville' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        Batiment::create($validated);

        return redirect()->route('batiments.index')->with('success', 'Bâtiment créé avec succès.');
    }

    /**
     * Afficher les détails d'un bâtiment spécifique avec ses logements.
     */
    public function show(Batiment $batiment)
    {
        $this->authorizeUser($batiment);

        // Charger les logements associés et compter automatiquement
        $batiment->loadCount('logements');
        $batiment->load('logements');

        return view('batiments.show', compact('batiment'));
    }

    public function edit(Batiment $batiment)
    {
        $this->authorizeUser($batiment);
        return view('batiments.edit', compact('batiment'));
    }

    public function update(Request $request, Batiment $batiment)
    {
        $this->authorizeUser($batiment);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:500',
            'ville' => 'required|string|max:255',
        ]);

        $batiment->update($validated);

        return redirect()->route('batiments.index')->with('success', 'Bâtiment mis à jour avec succès.');
    }

    public function destroy(Batiment $batiment)
    {
        $this->authorizeUser($batiment);
        $batiment->delete();

        return redirect()->route('batiments.index')->with('success', 'Bâtiment supprimé avec succès.');
    }

    private function authorizeUser(Batiment $batiment)
    {
        if ($batiment->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé à ce bâtiment.');
        }
    }
}