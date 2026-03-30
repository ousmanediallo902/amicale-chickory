<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depenses = Depense::orderByDesc('date')->get();

        return view('depenses.index', compact('depenses'));
    }

    /**
     * Exporter la liste des dépenses au format Excel.
     */
    public function export()
    {
        $depenses = Depense::orderByDesc('date')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Dépenses');

        $headers = [
            'Type',
            'Montant (FCFA)',
            'Date',
            'Description',
        ];

        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($depenses as $depense) {
            $sheet->setCellValue('A' . $row, ucfirst($depense->type));
            $sheet->setCellValue('B' . $row, $depense->montant);
            $sheet->setCellValue('C' . $row, $depense->date);
            $sheet->setCellValue('D' . $row, $depense->description ?? '');
            $row++;
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'depenses.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = [
            'loyer' => 'Loyer',
            'electricite' => 'Électricité',
            'eau' => 'Eau',
            'gaz' => 'Gaz',
            'vidange' => 'Vidange',
        ];

        return view('depenses.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:loyer,electricite,eau,gaz,vidange',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ], [
            'type.required' => 'Le type de dépense est obligatoire',
            'montant.required' => 'Le montant est obligatoire',
            'date.required' => 'La date est obligatoire',
        ]);

        Depense::create($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense enregistrée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depense $depense)
    {
        $types = [
            'loyer' => 'Loyer',
            'electricite' => 'Électricité',
            'eau' => 'Eau',
            'gaz' => 'Gaz',
            'vidange' => 'Vidange',
        ];

        return view('depenses.edit', compact('depense', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Depense $depense)
    {
        $validated = $request->validate([
            'type' => 'required|in:loyer,electricite,eau,gaz,vidange',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ], [
            'type.required' => 'Le type de dépense est obligatoire',
            'montant.required' => 'Le montant est obligatoire',
            'date.required' => 'La date est obligatoire',
        ]);

        $depense->update($validated);

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depense $depense)
    {
        $depense->delete();

        return redirect()->route('depenses.index')
            ->with('success', 'Dépense supprimée avec succès');
    }
}
