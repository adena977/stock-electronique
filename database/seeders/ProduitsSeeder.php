<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProduitsSeeder extends Seeder
{
    public function run(): void
    {
        // Chemin vers votre fichier CSV
        $csvFile = storage_path('app/produits.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("Fichier CSV non trouvé: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Première ligne = en-têtes

        while ($row = fgetcsv($file)) {
            DB::table('produits')->insert([
                'reference' => $row[0] ?? null,
                'nom' => $row[1] ?? null,
                'description' => $row[2] ?? null,
                'categorie' => $row[3] ?? null,
                'prix_achat' => $row[4] ?? 0,
                'prix_vente' => $row[5] ?? 0,
                'fournisseur' => $row[6] ?? null,
                'emplacement' => $row[7] ?? null,
                'image' => $row[8] ?? null,
                'quantite' => $row[9] ?? 0,
                'created_at' => $row[10] ?? now(),
                'updated_at' => $row[11] ?? now(),
            ]);
        }

        fclose($file);
        $this->command->info('Produits importés avec succès!');
    }
}