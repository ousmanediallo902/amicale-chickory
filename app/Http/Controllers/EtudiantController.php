<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Amicale;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etudiants = Etudiant::with('amicale')->get();
        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Exporter la liste des étudiants au format Excel.
     */
    public function export()
    {
        $etudiants = Etudiant::with('amicale')->orderBy('nom')->orderBy('prenom')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Étudiants');

        $headers = [
            'Nom',
            'Prénom',
            'Email',
            'Téléphone',
            'Maison',
            'Promotion',
        ];

        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $row = 2;
        foreach ($etudiants as $etudiant) {
            $sheet->setCellValue('A' . $row, $etudiant->nom);
            $sheet->setCellValue('B' . $row, $etudiant->prenom);
            $sheet->setCellValue('C' . $row, $etudiant->email ?? '');
            $sheet->setCellValue('D' . $row, $etudiant->telephone ?? '');
            $sheet->setCellValue('E' . $row, optional($etudiant->amicale)->nom ?? '');
            $sheet->setCellValue('F' . $row, $etudiant->promotion ?? '');
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'etudiants.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $amicales = Amicale::orderBy('nom')->get();
        return view('etudiants.create', compact('amicales'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amicale_id' => 'required|exists:amicales,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:etudiants,email',
            'telephone' => 'nullable|string|max:20',
            'promotion' => 'nullable|string|max:255'
        ], [
            'amicale_id.required' => 'La maison est obligatoire',
            'amicale_id.exists' => 'La maison sélectionnée est invalide',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'email.email' => 'L\'email doit être valide'
        ]);

        Etudiant::create($validated);

        return redirect()->route('etudiants.index')
            ->with('success','Étudiant ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        $amicales = Amicale::orderBy('nom')->get();
        return view('etudiants.edit', compact('etudiant', 'amicales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'amicale_id' => 'required|exists:amicales,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:etudiants,email,' . $etudiant->id,
            'telephone' => 'nullable|string|max:20',
            'promotion' => 'nullable|string|max:255'
        ], [
            'amicale_id.required' => 'La maison est obligatoire',
            'amicale_id.exists' => 'La maison sélectionnée est invalide',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'email.email' => 'L\'email doit être valide'
        ]);

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')
            ->with('success','Étudiant modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success','Étudiant supprimé avec succès');
    }
}
