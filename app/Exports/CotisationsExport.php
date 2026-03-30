<?php

namespace App\Exports;

use App\Models\Cotisation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CotisationsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Cotisation::with('etudiant')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get()
            ->map(function (Cotisation $cotisation) {
                $etudiant = $cotisation->etudiant;

                $typeLabel = match ($cotisation->type) {
                    'vidange' => 'Vidange',
                    'eau' => 'Eau',
                    'electricite' => 'Électricité',
                    'evenement' => 'Événement',
                    default => $cotisation->type,
                };

                $statutLabel = $cotisation->statut === 'paye' ? 'Payée' : 'Non payée';

                return [
                    'etudiant' => $etudiant ? ($etudiant->nom . ' ' . $etudiant->prenom) : '',
                    'type' => $typeLabel,
                    'mois' => $cotisation->mois,
                    'annee' => $cotisation->annee,
                    'montant' => $cotisation->montant,
                    'statut' => $statutLabel,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Étudiant',
            'Type',
            'Mois',
            'Année',
            'Montant (FCFA)',
            'Statut',
        ];
    }
}
