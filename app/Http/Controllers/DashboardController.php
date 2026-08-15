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

        // 1. Statistiques des structures
        $totalBatiments = Batiment::where('user_id', $userId)->count();
        $totalLogements = Logement::where('user_id', $userId)->count();
        $logementsDisponibles = Logement::where('user_id', $userId)->where('statut', true)->count();
        $logementsOccupes = Logement::where('user_id', $userId)->where('statut', false)->count();
        $totalLocataires = Locataire::where('user_id', $userId)->count();

        // 2. Calculs financiers
        $totalRevenus = Paiement::where('user_id', $userId)->sum('montant_paiement');
        $totalDepenses = Depense::where('user_id', $userId)->sum('montant_depenses');
        $soldeNet = $totalRevenus - $totalDepenses;

        // 3. Activités récentes
        $derniersPaiements = Paiement::where('user_id', $userId)
            ->with(['locataire.logement.batiment'])
            ->latest('date_paiement')
            ->take(5)
            ->get();

        $dernieresDepenses = Depense::where('user_id', $userId)
            ->with('batiment')
            ->latest()
            ->take(5)
            ->get();

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