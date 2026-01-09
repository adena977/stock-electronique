<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query();

        // Recherche par texte
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'LIKE', "%{$search}%")
                    ->orWhere('nom', 'LIKE', "%{$search}%")
                    ->orWhere('categorie', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par catégorie
        if ($request->has('categorie') && !empty($request->categorie)) {
            $query->where('categorie', $request->categorie);
        }

        // Trier les résultats
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $produits = $query->paginate(20);
        $totalProduits = Produit::count();

        // Liste des catégories distinctes pour le filtre
        $categories = Produit::select('categorie')->distinct()->orderBy('categorie')->pluck('categorie');

        return view('produits.index', compact(
            'produits',
            'totalProduits',
            'categories'
        ));
    }

    public function create()
    {
        // Plus besoin de passer $categories car c'est un input libre
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|unique:produits|max:50',
            'nom' => 'required|max:255',
            'categorie' => 'required|max:100',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
            'fournisseur' => 'nullable|max:255',
            'emplacement' => 'nullable|max:255',
        ]);

        $data = $request->only([
            'reference',
            'nom',
            'categorie',
            'prix_achat',
            'prix_vente',
            'description',
            'fournisseur',
            'emplacement'
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $data['image'] = $imagePath;
        }

        Produit::create($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit ajouté avec succès!');
    }

    public function edit(Produit $produit)
    {
        // Récupérer tous les produits triés (comme dans index)
        $produits = Produit::orderBy('created_at', 'desc')->get();

        return view('produits.edit', compact('produit', 'produits'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'reference' => 'required|max:50|unique:produits,reference,' . $produit->id,
            'nom' => 'required|max:255',
            'categorie' => 'required|max:100',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
            'fournisseur' => 'nullable|max:255',
            'emplacement' => 'nullable|max:255',
        ]);

        $data = $request->only([
            'reference',
            'nom',
            'categorie',
            'prix_achat',
            'prix_vente',
            'description',
            'fournisseur',
            'emplacement'
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                Storage::disk('public')->delete($produit->image);
            }

            $imagePath = $request->file('image')->store('produits', 'public');
            $data['image'] = $imagePath;
        }

        $produit->update($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour avec succès!');
    }

    public function destroy(Produit $produit)
    {
        // Supprimer l'image si elle existe
        if ($produit->image && Storage::disk('public')->exists($produit->image)) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();
        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès!');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }
}