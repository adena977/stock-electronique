@extends('layout.app')

@section('title', 'Détails du Produit')

@section('actions')
    <a href="{{ route('produits.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <a href="{{ route('produits.edit', $produit) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Modifier
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-eye"></i> Détails du Produit
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Image du produit -->
                    @if($produit->image)
                        @php
                            $imagePath = storage_path('app/public/' . $produit->image);
                            $imageExists = file_exists($imagePath);
                        @endphp
                        
                        <div class="text-center mb-4">
                            @if($imageExists)
                                <img src="{{ asset('storage/' . $produit->image) }}" 
                                     alt="{{ $produit->nom }}" 
                                     style="max-width: 300px; max-height: 300px; object-fit: cover;"
                                     class="img-thumbnail">
                                <br>
                                <small class="text-muted mt-2">
                                    Chemin: {{ $produit->image }}<br>
                                    URL: <a href="{{ asset('storage/' . $produit->image) }}" target="_blank">Voir l'image</a>
                                </small>
                            @else
                                <div style="width: 300px; height: 300px; background: #f8f9fa; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 2px dashed #ddd;">
                                    <div class="text-center">
                                        <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                                        <p class="text-muted mt-2">Image non trouvée</p>
                                        <small>Chemin: {{ $produit->image }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <div style="width: 300px; height: 300px; background: #f8f9fa; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 2px dashed #ddd;">
                                <div class="text-center">
                                    <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                                    <p class="text-muted mt-2">Aucune image disponible</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Information du produit -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Référence</label>
                            <p class="fw-bold h5">{{ $produit->reference }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nom du Produit</label>
                            <p class="fw-bold h5">{{ $produit->nom }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Catégorie</label>
                            <p>
                                <span class="badge bg-secondary fs-6">{{ $produit->categorie }}</span>
                            </p>
                        </div>

                        @if($produit->description)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Description</label>
                                <p>{{ $produit->description }}</p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Informations financières -->
                    <h6 class="mb-3"><i class="bi bi-currency-exchange"></i> Informations Financières</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Prix d'Achat</label>
                            <p class="fw-bold h5 text-success">
                                {{ number_format($produit->prix_achat, 0) }} FDJ
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Prix de Vente</label>
                            <p class="fw-bold h5 text-primary">
                                {{ number_format($produit->prix_vente, 0) }} FDJ
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Marge</label>
                            @php
                                $marge = $produit->prix_vente - $produit->prix_achat;
                            @endphp
                            <p
                                class="fw-bold h5 {{ $marge > 0 ? 'text-success' : ($marge < 0 ? 'text-danger' : 'text-muted') }}">
                                {{ $marge > 0 ? '+' : '' }}{{ number_format($marge, 0) }} FDJ
                            </p>
                            @if($produit->prix_achat > 0)
                                <small class="text-muted">
                                    Taux de marge: {{ number_format(($marge / $produit->prix_achat) * 100, 0) }}%
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    @if($produit->fournisseur || $produit->emplacement)
                        <hr>
                        <h6 class="mb-3"><i class="bi bi-info-circle"></i> Informations Supplémentaires</h6>
                        <div class="row">
                            @if($produit->fournisseur)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Fournisseur</label>
                                    <p>{{ $produit->fournisseur }}</p>
                                </div>
                            @endif

                            @if($produit->emplacement)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Emplacement</label>
                                    <p>{{ $produit->emplacement }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Informations système -->
                    <hr>
                    <h6 class="mb-3"><i class="bi bi-clock-history"></i> Informations Système</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date de création</label>
                            <p>{{ $produit->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Dernière modification</label>
                            <p>{{ $produit->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>

                        <div>
                            <a href="{{ route('produits.edit', $produit) }}" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite : Actions rapides -->
        <div class="col-md-4">
            <!-- Carte de l'image (petite version) -->
            @if($produit->image)
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-image"></i> Image du Produit</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $imagePath = storage_path('app/public/' . $produit->image);
                            $imageExists = file_exists($imagePath);
                        @endphp
                        
                        @if($imageExists)
                            <img src="{{ asset('storage/' . $produit->image) }}" 
                                 alt="{{ $produit->nom }}" 
                                 style="max-width: 100%; max-height: 200px; object-fit: cover;"
                                 class="img-thumbnail mb-2">
                            <div>
                                <a href="{{ asset('storage/' . $produit->image) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-zoom-in"></i> Agrandir
                                </a>
                            </div>
                        @else
                            <div style="height: 150px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                <div class="text-center">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Image non disponible</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list"></i> Voir tous les produits
                        </a>
                        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-outline-success">
                            <i class="bi bi-pencil"></i> Modifier ce produit
                        </a>
                        <a href="{{ route('produits.create') }}" class="btn btn-outline-warning">
                            <i class="bi bi-plus-circle"></i> Ajouter un nouveau produit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte de statistiques -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-graph-up"></i> Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">ID du produit</small>
                        <h6>#{{ $produit->id }}</h6>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Marge unitaire</small>
                        <h5 class="{{ $marge > 0 ? 'text-success' : ($marge < 0 ? 'text-danger' : 'text-muted') }}">
                            {{ $marge > 0 ? '+' : '' }}{{ number_format($marge, 0) }} FDJ
                        </h5>
                    </div>

                    @if($produit->prix_achat > 0)
                        <div class="mb-3">
                            <small class="text-muted">Taux de marge</small>
                            <h5 class="text-warning">
                                {{ number_format(($marge / $produit->prix_achat) * 100, 0) }}%
                            </h5>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Enregistré depuis</small>
                        <h6>{{ $produit->created_at->diffForHumans() }}</h6>
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
                        <li><strong>Prix Achat :</strong> {{ number_format($produit->prix_achat, 0) }} FDJ</li>
                        <li><strong>Prix Vente :</strong> {{ number_format($produit->prix_vente, 0) }} FDJ</li>
                        @if($produit->image)
                            <li><strong>Image :</strong> Oui (sera également supprimée)</li>
                        @endif
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
@endsection