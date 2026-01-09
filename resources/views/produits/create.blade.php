@extends('layout.app')

@section('title', 'Nouveau Produit')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Ajouter un Nouveau Produit
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="reference" class="form-label">Référence *</label>
                        <input type="text" class="form-control @error('reference') is-invalid @enderror" 
                               id="reference" name="reference" 
                               value="{{ old('reference') }}" 
                               required
                               placeholder="Ex: RES-1001, CAP-2200F">
                        @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom du Produit *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" 
                               value="{{ old('nom') }}" 
                               required
                               placeholder="Ex: Résistance 1K Ohm, Condensateur 100uF">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categorie" class="form-label">Catégorie *</label>
                        <input type="text" class="form-control @error('categorie') is-invalid @enderror" 
                               id="categorie" name="categorie" 
                               value="{{ old('categorie') }}" 
                               required
                               placeholder="Ex: Composants, Câbles, Outils">
                        @error('categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="prix_achat" class="form-label">Prix d'Achat (FDJ) *</label>
                        <div class="input-group">
                            <input type="number" step="0.01" 
                                   class="form-control @error('prix_achat') is-invalid @enderror" 
                                   id="prix_achat" name="prix_achat" 
                                   value="{{ old('prix_achat') }}" 
                                   required 
                                   min="0">
                            <span class="input-group-text">FDJ</span>
                        </div>
                        @error('prix_achat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prix_vente" class="form-label">Prix de Vente (FDJ) *</label>
                        <div class="input-group">
                            <input type="number" step="0.01" 
                                   class="form-control @error('prix_vente') is-invalid @enderror" 
                                   id="prix_vente" name="prix_vente" 
                                   value="{{ old('prix_vente') }}" 
                                   required
                                   min="0">
                            <span class="input-group-text">FDJ</span>
                        </div>
                        @error('prix_vente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-1">
                            Marge: 
                            <span id="marge-calcul" class="fw-bold">0 FDJ</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Image du produit</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Formats: JPEG, PNG, JPG, GIF (max: 2MB)
                        </small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" 
                                  rows="2" 
                                  placeholder="Description du produit...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="fournisseur" class="form-label">Fournisseur</label>
                        <input type="text" class="form-control @error('fournisseur') is-invalid @enderror" 
                               id="fournisseur" name="fournisseur" 
                               value="{{ old('fournisseur') }}" 
                               placeholder="Nom du fournisseur">
                        @error('fournisseur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="emplacement" class="form-label">Emplacement</label>
                        <input type="text" class="form-control @error('emplacement') is-invalid @enderror" 
                               id="emplacement" name="emplacement" 
                               value="{{ old('emplacement') }}" 
                               placeholder="Ex: Rayon A, Étagère 3">
                        @error('emplacement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prixAchat = document.getElementById('prix_achat');
            const prixVente = document.getElementById('prix_vente');
            const margeCalcul = document.getElementById('marge-calcul');
            
            function calculerMarge() {
                if (prixAchat.value && prixVente.value) {
                    const marge = parseFloat(prixVente.value) - parseFloat(prixAchat.value);
                    margeCalcul.textContent = marge.toLocaleString('fr-FR', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }) + ' FDJ';
                    
                    if (marge < 0) {
                        margeCalcul.classList.remove('text-success');
                        margeCalcul.classList.add('text-danger');
                    } else {
                        margeCalcul.classList.remove('text-danger');
                        margeCalcul.classList.add('text-success');
                    }
                }
            }
            
            prixAchat.addEventListener('input', calculerMarge);
            prixVente.addEventListener('input', calculerMarge);
            
            calculerMarge();
        });
    </script>
    @endpush
@endsection