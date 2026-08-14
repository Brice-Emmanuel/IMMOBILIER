<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Batiment;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Depense::with('batiment');

        // 1. Recherche par motif
        if ($request->filled('search')) {
            $query->where('motif', 'like', "%{$request->search}%");
        }

        // 2. Filtre par Bâtiment
        if ($request->filled('batiment_id')) {
            $query->where('batiment_id', $request->batiment_id);
        }

        // 3. Filtre par Date Début
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }

        // 4. Filtre par Date Fin
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Calcul du total des dépenses filtrées
        $totalDepenses = (clone $query)->sum('montant_depenses');

        // Conserve les filtres dans les liens de pagination (evite le soulignement rouge dans l'IDE)
        $depenses = $query->latest()->paginate(10)->appends($request->query());

        // Liste des bâtiments pour le filtre déroulant
        $batiments = Batiment::all();

        return view('depenses.index', compact('depenses', 'batiments', 'totalDepenses'));
    }

    public function create()
    {
        $batiments = Batiment::all();
        return view('depenses.create', compact('batiments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batiment_id'      => 'required|exists:batiments,id',
            'montant_depenses' => 'required|numeric|min:0',
            'motif'            => 'required|string|max:255',
        ]);

        Depense::create($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense enregistrée avec succès.');
    }

    public function show(Depense $depense)
    {
        $depense->load('batiment');
        return view('depenses.show', compact('depense'));
    }

    public function edit(Depense $depense)
    {
        $batiments = Batiment::all();
        return view('depenses.edit', compact('depense', 'batiments'));
    }

    public function update(Request $request, Depense $depense)
    {
        $validated = $request->validate([
            'batiment_id'      => 'required|exists:batiments,id',
            'montant_depenses' => 'required|numeric|min:0',
            'motif'            => 'required|string|max:255',
        ]);

        $depense->update($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy(Depense $depense)
    {
        $depense->delete();

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense supprimée avec succès.');
    }
}