<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use App\Models\Locataire;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocataireController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Récupérer la liste des bâtiments pour la barre de filtre
        $batiments = Batiment::where('user_id', $userId)->get();

        // Construction de la requête pour les locataires de l'utilisateur connecté
        $query = Locataire::where('user_id', $userId)
            ->with('logement.batiment');

        // 1. Recherche par Nom, Prénom, Téléphone ou Email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filtre par Bâtiment
        if ($request->filled('batiment_id')) {
            $batimentId = $request->batiment_id;
            $query->whereHas('logement', function ($q) use ($batimentId) {
                $q->where('batiment_id', $batimentId);
            });
        }

        // 3. Filtre par Statut d'attribution du logement (avec ou sans logement)
        if ($request->filled('statut_logement')) {
            if ($request->statut_logement === 'avec_logement') {
                $query->whereNotNull('logement_id');
            } elseif ($request->statut_logement === 'sans_logement') {
                $query->whereNull('logement_id');
            }
        }

        $locataires = $query->latest()->get();

        return view('locataires.index', compact('locataires', 'batiments'));
    }

    public function create()
    {
        // On récupère uniquement les logements libres du bailleur connecté
        $logements = Logement::where('user_id', auth()->id())
            ->where('statut', 1)
            ->get();

        return view('locataires.create', compact('logements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logement_id' => [
                'nullable',
                Rule::exists('logements', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:50',
            'phone_urgence' => 'nullable|string|max:50',
            'loyer' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();

        $locataire = Locataire::create($validated);

        // Si un logement a été attribué, marquer le logement comme occupé (0)
        if ($request->filled('logement_id')) {
            Logement::where('id', $request->logement_id)->update(['statut' => 0]);
        }

        return redirect()->route('locataires.index')->with('success', 'Locataire enregistré avec succès.');
    }

    public function edit(Locataire $locataire)
    {
        $this->authorizeUser($locataire);

        // Logements libres + le logement actuel attribué à ce locataire
        $logements = Logement::where('user_id', auth()->id())
            ->where(function ($query) use ($locataire) {
                $query->where('statut', 1)
                      ->orWhere('id', $locataire->logement_id);
            })
            ->get();

        return view('locataires.edit', compact('locataire', 'logements'));
    }

    public function update(Request $request, Locataire $locataire)
    {
        $this->authorizeUser($locataire);

        $validated = $request->validate([
            'logement_id' => [
                'nullable',
                Rule::exists('logements', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:50',
            'phone_urgence' => 'nullable|string|max:50',
            'loyer' => 'required|numeric|min:0',
        ]);

        $ancienLogementId = $locataire->logement_id;

        $locataire->update($validated);

        // Si changement de logement : libérer l'ancien (1) et occuper le nouveau (0)
        if ($ancienLogementId !== $request->logement_id) {
            if ($ancienLogementId) {
                Logement::where('id', $ancienLogementId)->update(['statut' => 1]);
            }
            if ($request->logement_id) {
                Logement::where('id', $request->logement_id)->update(['statut' => 0]);
            }
        }

        return redirect()->route('locataires.index')->with('success', 'Locataire mis à jour.');
    }

    public function destroy(Locataire $locataire)
    {
        $this->authorizeUser($locataire);

        // Libérer le logement lors du départ du locataire
        if ($locataire->logement_id) {
            Logement::where('id', $locataire->logement_id)->update(['statut' => 1]);
        }

        $locataire->delete();

        return redirect()->route('locataires.index')->with('success', 'Locataire supprimé.');
    }

    private function authorizeUser(Locataire $locataire)
    {
        if ($locataire->user_id !== auth()->id()) {
            abort(403);
        }
    }
}