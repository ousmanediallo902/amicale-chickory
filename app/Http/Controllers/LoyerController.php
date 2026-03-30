<?php

namespace App\Http\Controllers;

use App\Models\Loyer;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LoyerController extends Controller
{
    public function index()
    {
        $loyers = Loyer::with('etudiant')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        return view('loyers.index', compact('loyers'));
    }

    /**
     * Exporter la liste des loyers au format Excel.
     */
    public function export()
    {
        $loyers = Loyer::with('etudiant')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Loyers');

        $headers = [
            'Étudiant',
            'Mois',
            'Année',
            'Montant (FCFA)',
            'Statut',
        ];

        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $row = 2;
        foreach ($loyers as $loyer) {
            $etudiant = $loyer->etudiant;
            $sheet->setCellValue('A' . $row, $etudiant ? ($etudiant->nom . ' ' . $etudiant->prenom) : '');
            $sheet->setCellValue('B' . $row, $loyer->mois);
            $sheet->setCellValue('C' . $row, $loyer->annee);
            $sheet->setCellValue('D' . $row, $loyer->montant);
            $sheet->setCellValue('E' . $row, $loyer->statut === 'paye' ? 'Payé' : 'Non payé');
            $row++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'loyers.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function retards()
    {
        $loyers = Loyer::with('etudiant')
            ->where('statut', 'non_paye')
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        $afficherRetards = true;

        return view('loyers.index', compact('loyers', 'afficherRetards'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('nom')->orderBy('prenom')->get();
        $mois = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
        ];
        $annees = range(now()->year - 3, now()->year + 3);

        return view('loyers.create', compact('etudiants', 'mois', 'annees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'mois' => 'required|string|max:20',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|in:paye,non_paye',
        ]);

        Loyer::create($validated);

        return redirect()->route('loyers.index')
            ->with('success', 'Paiement de loyer enregistré avec succès');
    }

    public function edit(Loyer $loyer)
    {
        $etudiants = Etudiant::orderBy('nom')->orderBy('prenom')->get();
        $mois = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre',
        ];
        $annees = range(now()->year - 3, now()->year + 3);

        return view('loyers.edit', compact('loyer', 'etudiants', 'mois', 'annees'));
    }

    public function update(Request $request, Loyer $loyer)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'mois' => 'required|string|max:20',
            'annee' => 'required|integer|min:2000|max:2100',
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|in:paye,non_paye',
        ]);

        $loyer->update($validated);

        return redirect()->route('loyers.index')
            ->with('success', 'Paiement de loyer modifié avec succès');
    }

    public function destroy(Loyer $loyer)
    {
        $loyer->delete();

        return redirect()->route('loyers.index')
            ->with('success', 'Paiement de loyer supprimé avec succès');
    }
}
