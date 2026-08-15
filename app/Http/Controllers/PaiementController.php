<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Locataire;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    /**
     * Liste des paiements avec filtres et recherche
     */
    public function index(Request $request)
    {
        $query = Paiement::where('user_id', Auth::id())
            ->with(['locataire.logement.batiment']);

        // Recherche par mot-clé (Nom ou Prénom du locataire)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('locataire', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        // Filtre par locataire spécifique
        if ($request->filled('locataire_id')) {
            $query->where('locataire_id', $request->locataire_id);
        }

        // Filtre par mois/année de paiement (ex: 2026-08)
        if ($request->filled('mois')) {
            $date = explode('-', $request->mois);
            if (count($date) === 2) {
                $query->whereYear('date_paiement', $date[0])
                      ->whereMonth('date_paiement', $date[1]);
            }
        }

        // Tri (par défaut : plus récents d'abord)
        $sort = $request->get('sort', 'desc');
        $query->orderBy('date_paiement', $sort);

        $paiements = $query->paginate(15)->withQueryString();

        // Récupération de la liste des locataires pour le filtre
        $locataires = Locataire::where('user_id', Auth::id())->orderBy('nom')->get();

        return view('paiements.index', compact('paiements', 'locataires'));
    }

    /**
     * Formulaire d'ajout de paiement
     */
    public function create()
    {
        $locataires = Locataire::where('user_id', Auth::id())
            ->with('logement.batiment')
            ->get();

        return view('paiements.create', compact('locataires'));
    }

    /**
     * Enregistrement du paiement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'locataire_id' => [
                'required',
                Rule::exists('locataires', 'id')->where(fn ($query) => $query->where('user_id', Auth::id()))
            ],
            'montant_paiement' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'date_debut_conso' => 'required|date',
            'date_fin_conso' => 'required|date|after_or_equal:date_debut_conso',
        ]);

        $validated['user_id'] = Auth::id();

        $paiement = Paiement::create($validated);

        return redirect()->route('paiements.showRecu', $paiement->id)
            ->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Affichage web du reçu (impression / aperçu)
     */
    public function showRecu(Paiement $paiement)
    {
        $this->authorizeUser($paiement);

        $paiement->load(['locataire.logement.batiment', 'user']);

        return view('paiements.recu', compact('paiement'));
    }

    /**
     * Téléchargement du reçu au format PDF
     */
    public function downloadRecu(Paiement $paiement)
    {
        $this->authorizeUser($paiement);

        $paiement->load(['locataire.logement.batiment', 'user']);

        $pdf = Pdf::loadView('paiements.recu_pdf', compact('paiement'));

        return $pdf->download('recu_paiement_' . $paiement->id . '_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Vérification des droits de propriété du paiement
     */
    private function authorizeUser(Paiement $paiement): void
    {
        if ($paiement->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce reçu.');
        }
    }
}