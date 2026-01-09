@extends('layout.app')

@section('title', 'Modifier Produit')
@section('actions')
    <a href="{{ route('produits.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square"></i> Modifier le Produit
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('produits.update', $produit) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reference" class="form-label">Référence *</label>
                                <input type="text" class="form-control @error('reference') is-invalid @enderror"
                                    id="reference" name="reference" 
                                    value="{{ old('reference', $produit->reference) }}"
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
                                    value="{{ old('nom', $produit->nom) }}" 
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
                                    value="{{ old('categorie', $produit->categorie) }}" 
                                    required
                                    placeholder="Ex: Composants, Câbles, Outils">
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Image du produit</label>
                                
                                @if($produit->image)
                                    <div class="mb-2">
                                        <img src="{{ $produit->image_url }}" 
                                             alt="Image actuelle" 
                                             style="max-width: 100px; max-height: 100px; object-fit: cover;"
                                             class="img-thumbnail">
                                        <br>
                                        <small class="text-muted">Image actuelle</small>
                                    </div>
                                @endif
                                
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Laissez vide pour garder l'image actuelle. Formats: JPEG, PNG, JPG, GIF (max: 2MB)
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prix_achat" class="form-label">Prix d'Achat (FDJ) *</label>
                                <div class="input-group">
                                    <input type="number" step="0.01"
                                        class="form-control @error('prix_achat') is-invalid @enderror" 
                                        id="prix_achat" name="prix_achat" 
                                        value="{{ old('prix_achat', $produit->prix_achat) }}" 
                                        required min="0">
                                    <span class="input-group-text">FDJ</span>
                                </div>
                                @error('prix_achat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prix_vente" class="form-label">Prix de Vente (FDJ) *</label>
                                <div class="input-group">
                                    <input type="number" step="0.01"
                                        class="form-control @error('prix_vente') is-invalid @enderror" 
                                        id="prix_vente" name="prix_vente" 
                                        value="{{ old('prix_vente', $produit->prix_vente) }}" 
                                        required min="0">
                                    <span class="input-group-text">FDJ</span>
                                </div>
                                @error('prix_vente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-1">
                                    Marge: 
                                    <span id="marge-calcul" class="fw-bold">
                                        @php
                                            $marge = $produit->prix_vente - $produit->prix_achat;
                                        @endphp
                                        @if($marge > 0)
                                            <span class="text-success">+{{ number_format($marge, 0, ',', ' ') }} FDJ</span>
                                        @elseif($marge < 0)
                                            <span class="text-danger">{{ number_format($marge, 0, ',', ' ') }} FDJ</span>
                                        @else
                                            <span class="text-muted">0 FDJ</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" 
                                          rows="2">{{ old('description', $produit->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="fournisseur" class="form-label">Fournisseur</label>
                                <input type="text" class="form-control @error('fournisseur') is-invalid @enderror" 
                                       id="fournisseur" name="fournisseur" 
                                       value="{{ old('fournisseur', $produit->fournisseur) }}">
                                @error('fournisseur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="emplacement" class="form-label">Emplacement</label>
                                <input type="text" class="form-control @error('emplacement') is-invalid @enderror" 
                                       id="emplacement" name="emplacement" 
                                       value="{{ old('emplacement', $produit->emplacement) }}">
                                @error('emplacement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne de droite : Statistiques -->
        <div class="col-md-4">
            <!-- Carte de statistiques -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-graph-up"></i> Informations du Produit</h6>
                </div>
                <div class="card-body">
                     <!-- Image du produit -->
    @if($produit->image)
        <div class="text-center mb-4">
            <img src="{{ $produit->image_url }}" 
                 alt="{{ $produit->nom }}" 
                 style="max-width: 300px; max-height: 300px; object-fit: cover;"
                 class="img-thumbnail">
        </div>
    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted">Date d'ajout</small>
                        <h6>{{ $produit->created_at->format('d/m/Y H:i') }}</h6>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <h6>{{ $produit->updated_at->format('d/m/Y H:i') }}</h6>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Marge unitaire</small>
                        <h5 class="text-primary">
                            @php
                                $marge = $produit->prix_vente - $produit->prix_achat;
                            @endphp
                            @if($marge > 0)
                                <span class="text-success">+{{ number_format($marge, 0, ',', ' ') }} FDJ</span>
                            @elseif($marge < 0)
                                <span class="text-danger">{{ number_format($marge, 0, ',', ' ') }} FDJ</span>
                            @else
                                <span class="text-muted">0 FDJ</span>
                            @endif
                        </h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Taux de marge</small>
                        <h5 class="text-warning">
                            @php
                                $tauxMarge = $produit->prix_achat > 0 
                                    ? (($produit->prix_vente - $produit->prix_achat) / $produit->prix_achat) * 100 
                                    : 0;
                            @endphp
                            {{ number_format($tauxMarge, 0) }}%
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list"></i> Voir tous les produits
                        </a>
                        <a href="{{ route('produits.create') }}" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle"></i> Ajouter un nouveau produit
                        </a>
                        @if($produits->count() > 1)
                            @php
                                $nextProduct = $produits->where('id', '>', $produit->id)->first();
                                $prevProduct = $produits->where('id', '<', $produit->id)->last();
                            @endphp
                            <div class="btn-group">
                                @if($prevProduct)
                                    <a href="{{ route('produits.edit', $prevProduct) }}" class="btn btn-outline-info">
                                        <i class="bi bi-chevron-left"></i> Précédent
                                    </a>
                                @endif
                                @if($nextProduct)
                                    <a href="{{ route('produits.edit', $nextProduct) }}" class="btn btn-outline-info">
                                        Suivant <i class="bi bi-chevron-right"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Confirmation de suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Attention :</strong> Cette action est irréversible.
                    </div>
                    <ul>
                        <li><strong>Produit :</strong> {{ $produit->nom }}</li>
                        <li><strong>Référence :</strong> {{ $produit->reference }}</li>
                        <li><strong>Catégorie :</strong> {{ $produit->categorie }}</li>
                        <li><strong>Prix Achat :</strong> {{ $produit->prix_achat_format }}</li>
                        <li><strong>Prix Vente :</strong> {{ $produit->prix_vente_format }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Annuler
                    </button>
                    <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour calculer automatiquement les marges -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const prixAchat = document.getElementById('prix_achat');
                const prixVente = document.getElementById('prix_vente');
                const margeCalcul = document.getElementById('marge-calcul');
                
                function calculerMarge() {
                    if (prixAchat.value && prixVente.value) {
                        const marge = parseFloat(prixVente.value) - parseFloat(prixAchat.value);
                        const formattedMarge = marge.toLocaleString('fr-FR', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }) + ' FDJ';
                        
                        if (marge > 0) {
                            margeCalcul.innerHTML = '<span class="text-success">+' + formattedMarge + '</span>';
                        } else if (marge < 0) {
                            margeCalcul.innerHTML = '<span class="text-danger">' + formattedMarge + '</span>';
                        } else {
                            margeCalcul.innerHTML = '<span class="text-muted">0 FDJ</span>';
                        }
                    }
                }
                
                // Calculer la marge quand les prix changent
                prixAchat.addEventListener('input', calculerMarge);
                prixVente.addEventListener('input', calculerMarge);
                
                // Calcul initial
                calculerMarge();
            });
        </script>
    @endpush
@endsection