<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cotisations = Cotisation::with('etudiant')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        return view('cotisations.index', compact('cotisations'));
    }

    /**
     * Exporter la liste des cotisations au format Excel.
     */
    public function export()
    {
        $cotisations = Cotisation::with('etudiant')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        // Créer un objet Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Cotisations');

        // Ajouter les en-têtes
        $headers = [
            'Étudiant',
            'Type',
            'Mois',
            'Année',
            'Montant (FCFA)',
            'Statut',
        ];

        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Rendre les en-têtes gras
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD3D3D3');

        // Ajouter les données
        $row = 2;
        foreach ($cotisations as $cotisation) {
            $etudiant = $cotisation->etudiant;

            $typeLabel = match ($cotisation->type) {
                'vidange' => 'Vidange',
                'eau' => 'Eau',
                'electricite' => 'Électricité',
                'evenement' => 'Événement',
                default => $cotisation->type,
            };

            $statutLabel = $cotisation->statut === 'paye' ? 'Payée' : 'Non payée';

            $sheet->setCellValue('A' . $row, $etudiant ? ($etudiant->nom . ' ' . $etudiant->prenom) : '');
            $sheet->setCellValue('B' . $row, $typeLabel);
            $sheet->setCellValue('C' . $row, $cotisation->mois);
            $sheet->setCellValue('D' . $row, $cotisation->annee);
            $sheet->setCellValue('E' . $row, $cotisation->montant);
            $sheet->setCellValue('F' . $row, $statutLabel);

            $row++;
        }

        // Ajuster la largeur des colonnes
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        // Créer le writer pour le format Excel
        $writer = new Xlsx($spreadsheet);

        // Retourner le fichier téléchargé
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'cotisations.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etudiants = Etudiant::orderBy('nom')->orderBy('prenom')->get();
        $mois = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
        ];
        $annees = range(now()->year - 3, now()->year + 3);
        $types = [
            'vidange' => 'Vidange',
            'eau' => 'Eau',
            'electricite' => 'Électricité',
            'evenement' => 'Événement',
        ];

        return view('cotisations.create', compact('etudiants', 'mois', 'annees', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'type' => 'required|in:vidange,eau,electricite,evenement',
            'mois' => 'required|string|max:20',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|in:paye,non_paye',
        ], [
            'etudiant_id.required' => "L'étudiant est obligatoire",
            'etudiant_id.exists' => "L'étudiant sélectionné est invalide",
            'type.required' => 'Le type de cotisation est obligatoire',
            'mois.required' => 'Le mois est obligatoire',
            'annee.required' => "L'année est obligatoire",
            'montant.required' => 'Le montant est obligatoire',
        ]);

        Cotisation::create($validated);

        return redirect()->route('cotisations.index')
            ->with('success', 'Cotisation enregistrée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotisation $cotisation)
    {
        $etudiants = Etudiant::orderBy('nom')->orderBy('prenom')->get();
        $mois = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
        ];
        $annees = range(now()->year - 3, now()->year + 3);
        $types = [
            'vidange' => 'Vidange',
            'eau' => 'Eau',
            'electricite' => 'Électricité',
            'evenement' => 'Événement',
        ];

        return view('cotisations.edit', compact('cotisation', 'etudiants', 'mois', 'annees', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cotisation $cotisation)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'type' => 'required|in:vidange,eau,electricite,evenement',
            'mois' => 'required|string|max:20',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|in:paye,non_paye',
        ], [
            'etudiant_id.required' => "L'étudiant est obligatoire",
            'etudiant_id.exists' => "L'étudiant sélectionné est invalide",
            'type.required' => 'Le type de cotisation est obligatoire',
            'mois.required' => 'Le mois est obligatoire',
            'annee.required' => "L'année est obligatoire",
            'montant.required' => 'Le montant est obligatoire',
        ]);

        $cotisation->update($validated);

        return redirect()->route('cotisations.index')
            ->with('success', 'Cotisation modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotisation $cotisation)
    {
        $cotisation->delete();

        return redirect()->route('cotisations.index')
            ->with('success', 'Cotisation supprimée avec succès');
    }
}
