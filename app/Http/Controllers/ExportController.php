<?php

namespace App\Http\Controllers;

use App\Exports\ProduitsExport;
use App\Exports\ProduitsPdfExport;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ProduitsExport, 'produits_' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $produits = Produit::all();

        $pdf = Pdf::loadView('exports.produits-pdf', [
            'produits' => $produits,
            'date' => now()->format('d/m/Y')
        ]);

        return $pdf->download('produits_' . date('Y-m-d') . '.pdf');
    }
    public function exportCsv()
    {
        return Excel::download(new ProduitsExport, 'produits_' . date('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}