<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Batiment;
use Illuminate\Http\Request;

class LogementController extends Controller
{
    /**
     * Liste des logements filtrés par Catégorie et Statut uniquement.
     */
    public function index(Request $request)
    {
        $query = Logement::whereHas('batiment', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('batiment');

        // 1. Filtre par Catégorie
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // 2. Filtre par Statut (1 = Disponible / 0 = Occupé)
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $logements = $query->latest()->paginate(10)->appends($request->query());

        return view('logements.index', compact('logements'));
    }

    /**
     * Formulaire de création d'un logement.
     */
    public function create()
    {
        $batiments = Batiment::where('user_id', auth()->id())->get();
        return view('logements.create', compact('batiments'));
    }

    /**
     * Enregistrement d'un nouveau logement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batiment_id'   => 'required|exists:batiments,id',
            'numero'        => 'nullable|string|max:255',
            'categorie'     => 'required|in:appartement,maison,studio,boutique,bureau',
            'loyer_mensuel' => 'required|numeric|min:0',
            'statut'        => 'required',
            'description'   => 'nullable|string',
        ]);

        $validated['statut'] = in_array($request->statut, ['1', 'disponible', true], true);

        Logement::create($validated);

        return redirect()->route('logements.index')
            ->with('success', 'Logement créé avec succès.');
    }

    /**
     * Affichage des détails d'un logement.
     */
    public function show(Logement $logement)
    {
        $logement->load('batiment');
        return view('logements.show', compact('logement'));
    }

    /**
     * Formulaire de modification d'un logement.
     */
    public function edit(Logement $logement)
    {
        $batiments = Batiment::where('user_id', auth()->id())->get();
        return view('logements.edit', compact('logement', 'batiments'));
    }

    /**
     * Mise à jour d'un logement existant.
     */
    public function update(Request $request, Logement $logement)
    {
        $validated = $request->validate([
            'batiment_id'   => 'required|exists:batiments,id',
            'numero'        => 'nullable|string|max:255',
            'categorie'     => 'required|in:appartement,maison,studio,boutique,bureau',
            'loyer_mensuel' => 'required|numeric|min:0',
            'statut'        => 'nullable',
            'description'   => 'nullable|string',
        ]);

        // Si la case à cocher 'statut' est présente, le logement est disponible (true), sinon occupé (false)
        $validated['statut'] = $request->has('statut');

        $logement->update($validated);

        return redirect()->route('logements.index')
            ->with('success', 'Logement mis à jour avec succès.');
    }

    /**
     * Suppression d'un logement.
     */
    public function destroy(Logement $logement)
    {
        $logement->delete();

        return redirect()->route('logements.index')
            ->with('success', 'Logement supprimé avec succès.');
    }
}