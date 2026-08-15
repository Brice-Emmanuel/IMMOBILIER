<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Batiment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LogementController extends Controller
{
    public function index(Request $request)
    {
        // Bâtiments du bailleur pour le menu déroulant du filtre
        $batiments = Batiment::where('user_id', auth()->id())->get();

        // Construction de la requête
        $query = Logement::where('user_id', auth()->id())->with('batiment');

        // Filtre par Recherche (numéro / porte)
        if ($request->filled('search')) {
            $query->where('numero', 'like', '%' . $request->search . '%');
        }

        // Filtre par Bâtiment
        if ($request->filled('batiment_id')) {
            $query->where('batiment_id', $request->batiment_id);
        }

        // Filtre par Catégorie
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Filtre par Statut (0 = Occupé, 1 = Libre)
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $logements = $query->latest()->get();

        return view('logements.index', compact('logements', 'batiments'));
    }

    public function create()
    {
        $batiments = Batiment::where('user_id', auth()->id())->get();

        return view('logements.create', compact('batiments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batiment_id' => [
                'required',
                Rule::exists('batiments', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'numero' => 'nullable|string|max:50',
            'categorie' => 'required|in:appartement,maison,studio,boutique,bureau',
            'description' => 'nullable|string',
            'loyer_mensuel' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['statut'] = 1; // Libre (1) par défaut

        Logement::create($validated);

        return redirect()->route('logements.index')->with('success', 'Logement ajouté avec succès.');
    }

    public function edit(Logement $logement)
    {
        $this->authorizeUser($logement);

        $batiments = Batiment::where('user_id', auth()->id())->get();

        return view('logements.edit', compact('logement', 'batiments'));
    }

    public function update(Request $request, Logement $logement)
    {
        $this->authorizeUser($logement);

        $validated = $request->validate([
            'batiment_id' => [
                'required',
                Rule::exists('batiments', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'numero' => 'nullable|string|max:50',
            'categorie' => 'required|in:appartement,maison,studio,boutique,bureau',
            'description' => 'nullable|string',
            'loyer_mensuel' => 'required|numeric|min:0',
        ]);

        $logement->update($validated);

        return redirect()->route('logements.index')->with('success', 'Logement mis à jour avec succès.');
    }

    public function destroy(Logement $logement)
    {
        $this->authorizeUser($logement);
        $logement->delete();

        return redirect()->route('logements.index')->with('success', 'Logement supprimé.');
    }

    private function authorizeUser(Logement $logement)
    {
        if ($logement->user_id !== auth()->id()) {
            abort(403);
        }
    }
}