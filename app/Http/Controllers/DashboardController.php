<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use App\Models\Logement;
use App\Models\Locataire;
use App\Models\Paiement;
use App\Models\Depense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Récupération des IDs des bâtiments de l'utilisateur connecté
        $batimentIds = Batiment::where('user_id', $userId)->pluck('id');

        // 2. Récupération des IDs des logements associés
        $logementIds = Logement::whereIn('batiment_id', $batimentIds)->pluck('id');

        // Statistiques principales
        $totalBatiments = $batimentIds->count();
        $totalLogements = $logementIds->count();
        $logementsDisponibles = Logement::whereIn('batiment_id', $batimentIds)->where('statut', true)->count();
        $logementsOccupes = Logement::whereIn('batiment_id', $batimentIds)->where('statut', false)->count();

        // Récupération des locataires : si logement_id est renseigné OU s'il y a des locataires globaux
        $locatairesQuery = Locataire::query();
        if ($logementIds->isNotEmpty()) {
            $locatairesQuery->where(function ($q) use ($logementIds) {
                $q->whereIn('logement_id', $logementIds)
                  ->orWhereNull('logement_id'); // Prendre aussi en compte les locataires sans logement_id direct
            });
        }
        
        $totalLocataires = Locataire::count(); // Ou $locatairesQuery->count() selon votre besoin

        // Calculs financiers : Récupérer TOUS les paiements (ou filtrés si logement_id existe)
        if ($logementIds->isNotEmpty()) {
            $totalRevenus = Paiement::whereHas('locataire', function ($query) use ($logementIds) {
                $query->whereIn('logement_id', $logementIds)
                      ->orWhereNull('logement_id');
            })->sum('montant_paiement');

            $derniersPaiements = Paiement::whereHas('locataire', function ($query) use ($logementIds) {
                $query->whereIn('logement_id', $logementIds)
                      ->orWhereNull('logement_id');
            })->with('locataire')->latest()->take(5)->get();
        } else {
            // Si l'utilisateur n'a pas encore de bâtiments/logements configurés mais a créé des paiements
            $totalRevenus = Paiement::sum('montant_paiement');
            $derniersPaiements = Paiement::with('locataire')->latest()->take(5)->get();
        }

        $totalDepenses = Depense::whereIn('batiment_id', $batimentIds)->sum('montant_depenses');
        $soldeNet = $totalRevenus - $totalDepenses;

        // Dernières dépenses
        $dernieresDepenses = Depense::whereIn('batiment_id', $batimentIds)->with('batiment')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBatiments',
            'totalLogements',
            'logementsDisponibles',
            'logementsOccupes',
            'totalLocataires',
            'totalRevenus',
            'totalDepenses',
            'soldeNet',
            'derniersPaiements',
            'dernieresDepenses'
        ));
    }
}