<?php

namespace App\Http\Controllers;

use App\Models\Subvention;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SubventionController extends Controller
{
    public function index()
    {
        $subventions = Subvention::orderByDesc('date')->get();

        return view('subventions.index', compact('subventions'));
    }

    /**
     * Exporter la liste des subventions au format Excel.
     */
    public function export()
    {
        $subventions = Subvention::orderByDesc('date')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Subventions');

        $headers = [
            'Source',
            'Type',
            'Montant (FCFA)',
            'Date',
            'Description',
        ];

        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '1';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $row = 2;
        foreach ($subventions as $subvention) {
            $sheet->setCellValue('A' . $row, $subvention->source);
            $sheet->setCellValue('B' . $row, ucfirst($subvention->type));
            $sheet->setCellValue('C' . $row, $subvention->montant);
            $sheet->setCellValue('D' . $row, $subvention->date);
            $sheet->setCellValue('E' . $row, $subvention->description ?? '');
            $row++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'subventions.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function create()
    {
        $types = [
            'subvention' => 'Subvention',
            'aide' => 'Aide',
            'don' => 'Don',
            'autre' => 'Autre',
        ];

        return view('subventions.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'type' => 'required|in:subvention,aide,don,autre',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Subvention::create($validated);

        return redirect()->route('subventions.index')
            ->with('success', 'Subvention / aide enregistrée avec succès');
    }

    public function edit(Subvention $subvention)
    {
        $types = [
            'subvention' => 'Subvention',
            'aide' => 'Aide',
            'don' => 'Don',
            'autre' => 'Autre',
        ];

        return view('subventions.edit', compact('subvention', 'types'));
    }

    public function update(Request $request, Subvention $subvention)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'type' => 'required|in:subvention,aide,don,autre',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $subvention->update($validated);

        return redirect()->route('subventions.index')
            ->with('success', 'Subvention / aide modifiée avec succès');
    }

    public function destroy(Subvention $subvention)
    {
        $subvention->delete();

        return redirect()->route('subventions.index')
            ->with('success', 'Subvention / aide supprimée avec succès');
    }
}
