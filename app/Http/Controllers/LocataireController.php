<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocataireController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Récupère uniquement les locataires associés aux logements des bâtiments de l'utilisateur connecté
        $query = Locataire::whereHas('logement.batiment', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            // Inclut aussi les locataires sans logement si leur création/bâtiment est rattaché à cet utilisateur
            $q->whereNull('logement_id');
        })->with('logement.batiment');

        // 1. Recherche par nom, prénom, téléphone ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filtre par Logement spécifique
        if ($request->filled('logement_id')) {
            $query->where('logement_id', $request->logement_id);
        }

        // 3. Filtre par Statut d'attribution
        if ($request->filled('assignation')) {
            if ($request->assignation === 'assigne') {
                $query->whereNotNull('logement_id');
            } elseif ($request->assignation === 'non_assigne') {
                $query->whereNull('logement_id');
            }
        }

        $locataires = $query->latest()->paginate(10)->appends($request->query());

        // Récupère uniquement les LOGEMENTS des bâtiments appartenant à l'utilisateur connecté
        $logements = Logement::whereHas('batiment', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('batiment')->get();

        return view('locataires.index', compact('locataires', 'logements'));
    }

    public function create()
    {
        // Récupère uniquement les LOGEMENTS appartenant aux bâtiments de l'utilisateur
        $logements = Logement::whereHas('batiment', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('batiment')->get();

        return view('locataires.create', compact('logements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:255',
            'prenom'        => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'required|string|max:50',
            'phone_urgence' => 'nullable|string|max:50',
            'loyer'         => 'nullable|numeric|min:0',
            'logement_id'   => [
                'nullable',
                // S'assure que le logement sélectionné appartient bien à l'utilisateur connecté
                Rule::exists('logements', 'id')->where(function ($query) {
                    $query->whereHas('batiment', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
                }),
            ],
        ]);

        Locataire::create($validated);

        return redirect()->route('locataires.index')
            ->with('success', 'Locataire ajouté avec succès.');
    }

    public function show(Locataire $locataire)
    {
        $locataire->load(['paiements', 'logement.batiment']);
        return view('locataires.show', compact('locataire'));
    }

    public function edit(Locataire $locataire)
    {
        // Récupère la liste des LOGEMENTS de l'utilisateur connecté
        $logements = Logement::whereHas('batiment', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('batiment')->get();

        return view('locataires.edit', compact('locataire', 'logements'));
    }

    public function update(Request $request, Locataire $locataire)
    {
        $validated = $request->validate([
            'nom'           => 'required|string|max:255',
            'prenom'        => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'required|string|max:50',
            'phone_urgence' => 'nullable|string|max:50',
            'loyer'         => 'nullable|numeric|min:0',
            'logement_id'   => [
                'nullable',
                Rule::exists('logements', 'id')->where(function ($query) {
                    $query->whereHas('batiment', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
                }),
            ],
        ]);

        $locataire->update($validated);

        return redirect()->route('locataires.index')
            ->with('success', 'Informations du locataire mises à jour avec succès.');
    }

    public function destroy(Locataire $locataire)
    {
        $locataire->delete();

        return redirect()->route('locataires.index')
            ->with('success', 'Locataire supprimé avec succès.');
    }
}