<?php

namespace App\Exports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProduitsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Produit::all();
    }

    public function headings(): array
    {
        return [
            'Référence',
            'Nom',
            'Catégorie',
            'Prix Achat (FDJ)',
            'Prix Vente (FDJ)',
            'Quantité',
            'Seuil Alerte',
            'Valeur Stock (FDJ)',
            'Fournisseur',
            'Emplacement'
        ];
    }

    public function map($produit): array
    {
        return [
            $produit->reference,
            $produit->nom,
            $produit->categorie,
            number_format($produit->prix_achat, 0, ',', ' '),
            number_format($produit->prix_vente, 0, ',', ' '),
            $produit->quantite,
            $produit->seuil_alerte,
            number_format($produit->valeur_stock, 0, ',', ' '),
            $produit->fournisseur,
            $produit->emplacement
        ];
    }
}