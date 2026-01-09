<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'nom',
        'categorie',
        'prix_achat',
        'prix_vente',
        'image',
        'description',
        'fournisseur',
        'emplacement'
    ];

    protected $casts = [
        'prix_achat' => 'decimal:2',
        'prix_vente' => 'decimal:2',
    ];

    public function getPrixAchatFormatAttribute()
    {
        return number_format($this->prix_achat, 0, ',', ' ') . ' FDJ';
    }

    public function getPrixVenteFormatAttribute()
    {
        return number_format($this->prix_vente, 0, ',', ' ') . ' FDJ';
    }

    public function getMargeAttribute()
    {
        return $this->prix_vente - $this->prix_achat;
    }

    public function getMargeFormatAttribute()
    {
        return number_format($this->marge, 0, ',', ' ') . ' FDJ';
    }

    // Accessor pour l'URL de l'image
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.png'); // Image par défaut
    }
}