<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Cotisation;
use App\Models\Depense;
use App\Models\Evenement;
use App\Models\Loyer;
use App\Models\Subvention;

class DashboardController extends Controller
{
    public function index()
    {
        $nbEtudiants = Etudiant::count();
        $totalLoyersPayes = Loyer::where('statut', 'paye')->sum('montant');
        $totalLoyersNonPayes = Loyer::where('statut', 'non_paye')->sum('montant');

        // Nombre d'étudiants ayant au moins un loyer non payé (en retard)
        $nbEtudiantsEnRetardLoyer = Loyer::where('statut', 'non_paye')
            ->distinct('etudiant_id')
            ->count('etudiant_id');

        $totalCotisations = Cotisation::sum('montant');
        $totalSubventions = Subvention::sum('montant');
        $totalDepenses = Depense::sum('montant');

        $totalRecettes = $totalCotisations + $totalLoyersPayes + $totalSubventions;
        $resteCaisse = $totalRecettes - $totalDepenses;

        // Événements à venir (y compris ceux d'aujourd'hui, en ignorant l'heure)
        $today = now()->toDateString();
        $nbEvenements = Evenement::whereDate('date', '>=', $today)->count();
        $prochainsEvenements = Evenement::whereDate('date', '>=', $today)
                        ->orderBy('date', 'asc')
                        ->take(3)
                        ->get();

        return view('dashboard', compact(
            'nbEtudiants',
            'totalCotisations',
            'totalSubventions',
            'totalRecettes',
            'totalDepenses',
            'resteCaisse',
            'totalLoyersPayes',
            'totalLoyersNonPayes',
            'nbEtudiantsEnRetardLoyer',
            'nbEvenements',
            'prochainsEvenements'
        ));
    }
}