<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Locataire;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with('locataire.logement');

        // 1. Filtre par Locataire
        if ($request->filled('locataire_id')) {
            $query->where('locataire_id', $request->locataire_id);
        }

        // 2. Recherche textuelle dans les notes / remarques
        if ($request->filled('search')) {
            $query->where('note', 'like', "%{$request->search}%");
        }

        // 3. Filtre par Date Début de paiement
        if ($request->filled('date_debut')) {
            $query->whereDate('date_paiement', '>=', $request->date_debut);
        }

        // 4. Filtre par Date Fin de paiement
        if ($request->filled('date_fin')) {
            $query->whereDate('date_paiement', '<=', $request->date_fin);
        }

        // Total des encaissements pour la sélection
        $totalPaiements = (clone $query)->sum('montant_paiement');

        // Conserve les filtres dans les liens de pagination (appends)
        $paiements = $query->latest('date_paiement')->paginate(10)->appends($request->query());

        // Liste des locataires pour le filtre déroulant
        $locataires = Locataire::orderBy('nom')->get();

        return view('paiements.index', compact('paiements', 'locataires', 'totalPaiements'));
    }

    public function create()
    {
        $locataires = Locataire::orderBy('nom')->get();
        return view('paiements.create', compact('locataires'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'locataire_id'     => 'required|exists:locataires,id',
            'montant_paiement' => 'required|numeric|min:0',
            'date_paiement'    => 'required|date',
            'date_debut_conso' => 'required|date',
            'date_fin_conso'   => 'required|date|after_or_equal:date_debut_conso',
            'note'             => 'nullable|string|max:255',
        ]);

        Paiement::create($validated);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement enregistré avec succès.');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load('locataire.logement');
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $locataires = Locataire::orderBy('nom')->get();
        return view('paiements.edit', compact('paiement', 'locataires'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'locataire_id'     => 'required|exists:locataires,id',
            'montant_paiement' => 'required|numeric|min:0',
            'date_paiement'    => 'required|date',
            'date_debut_conso' => 'required|date',
            'date_fin_conso'   => 'required|date|after_or_equal:date_debut_conso',
            'note'             => 'nullable|string|max:255',
        ]);

        $paiement->update($validated);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }
}