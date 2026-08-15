<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Batiment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepenseController extends Controller
{
    /**
     * Liste des dépenses avec filtres et recherche
     */
    public function index(Request $request)
    {
        $query = Depense::where('user_id', auth()->id())
            ->with('batiment');

        // Recherche par motif
        if ($request->filled('search')) {
            $query->where('motif', 'like', '%' . $request->search . '%');
        }

        // Filtre par Bâtiment
        if ($request->filled('batiment_id')) {
            $query->where('batiment_id', $request->batiment_id);
        }

        // Tri (par défaut : plus récentes d'abord)
        $sort = $request->get('sort', 'desc');
        $query->orderBy('created_at', $sort);

        $depenses = $query->paginate(15)->withQueryString();

        // Récupération des bâtiments pour le filtre
        $batiments = Batiment::where('user_id', auth()->id())->orderBy('name')->get();

        return view('depenses.index', compact('depenses', 'batiments'));
    }

    public function create()
    {
        // Récupère la liste des bâtiments appartenant à l'utilisateur connecté
        $batiments = Batiment::where('user_id', auth()->id())->get();

        return view('depenses.create', compact('batiments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batiment_id' => [
                'required',
                Rule::exists('batiments', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'montant_depenses' => 'required|numeric|min:0',
            'motif' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        Depense::create($validated);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée.');
    }

    public function destroy(Depense $depense)
    {
        if ($depense->user_id !== auth()->id()) {
            abort(403);
        }

        $depense->delete();

        return redirect()->route('depenses.index')->with('success', 'Dépense supprimée.');
    }
}