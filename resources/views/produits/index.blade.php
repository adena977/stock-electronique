@extends('layout.app')

@section('title', 'Tableau de bord')

@section('actions')
    <a href="{{ route('export.excel') }}" class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Exporter Excel
    </a>
    <a href="{{ route('produits.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouveau Produit
    </a>
@endsection

@section('content')
<!-- Formulaire de recherche et filtrage -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="mb-0"><i class="bi bi-search"></i> Recherche & Filtrage</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('produits.index') }}" class="row g-3">
            <!-- Recherche générale -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Rechercher par référence, nom ou catégorie..."
                           value="{{ request('search') }}">
                    @if(request('search'))
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary" 
                           title="Effacer la recherche">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Filtre par catégorie -->
            <div class="col-md-3">
                <select name="categorie" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie }}" {{ request('categorie') == $categorie ? 'selected' : '' }}>
                            {{ $categorie }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filtre par prix -->
            <div class="col-md-2">
                <input type="number" name="prix_min" class="form-control" 
                       placeholder="Prix min" 
                       value="{{ request('prix_min') }}">
            </div>
            
            <div class="col-md-2">
                <input type="number" name="prix_max" class="form-control" 
                       placeholder="Prix max" 
                       value="{{ request('prix_max') }}">
            </div>
            
            <!-- Boutons -->
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i>
                </button>
            </div>
        </form>
        
        <!-- Filtres actifs -->
        @if(request()->anyFilled(['search', 'categorie', 'prix_min', 'prix_max']))
        <div class="mt-3">
            <small class="text-muted">Filtres actifs :</small>
            <div class="d-flex flex-wrap gap-2 mt-1">
                @if(request('search'))
                    <span class="badge bg-info">
                        Recherche: {{ request('search') }}
                        <a href="{{ route('produits.index', request()->except('search')) }}" 
                           class="text-white ms-2" style="text-decoration: none;">×</a>
                    </span>
                @endif
                
                @if(request('categorie'))
                    <span class="badge bg-info">
                        Catégorie: {{ request('categorie') }}
                        <a href="{{ route('produits.index', request()->except('categorie')) }}" 
                           class="text-white ms-2" style="text-decoration: none;">×</a>
                    </span>
                @endif
                
                @if(request('prix_min'))
                    <span class="badge bg-info">
                        Prix min: {{ request('prix_min') }} FDJ
                        <a href="{{ route('produits.index', request()->except('prix_min')) }}" 
                           class="text-white ms-2" style="text-decoration: none;">×</a>
                    </span>
                @endif
                
                @if(request('prix_max'))
                    <span class="badge bg-info">
                        Prix max: {{ request('prix_max') }} FDJ
                        <a href="{{ route('produits.index', request()->except('prix_max')) }}" 
                           class="text-white ms-2" style="text-decoration: none;">×</a>
                    </span>
                @endif
                
                <a href="{{ route('produits.index') }}" class="badge bg-danger text-decoration-none">
                    <i class="bi bi-x-circle"></i> Tout effacer
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Produits</h6>
                        <h2>{{ $totalProduits }}</h2>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Résultats</h6>
                        <h2>{{ $produits->total() }}</h2>
                        <small>{{ $produits->count() }} affichés</small>
                    </div>
                    <i class="bi bi-filter" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tableau des produits -->
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-list"></i> Liste des Produits</h5>
        
        <!-- Tri des colonnes -->
        <div class="d-flex align-items-center">
            <span class="me-2">Trier par:</span>
            <div class="btn-group btn-group-sm">
                @php
                    $currentSort = request('sort_by', 'created_at');
                    $currentOrder = request('sort_order', 'desc');
                    $newOrder = $currentOrder === 'asc' ? 'desc' : 'asc';
                @endphp
                
                <a href="{{ route('produits.index', array_merge(request()->all(), ['sort_by' => 'nom', 'sort_order' => request('sort_by') == 'nom' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" 
                   class="btn {{ $currentSort == 'nom' ? 'btn-light' : 'btn-outline-light' }}">
                    Nom
                    @if($currentSort == 'nom')
                        <i class="bi bi-arrow-{{ $currentOrder == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
                
                <a href="{{ route('produits.index', array_merge(request()->all(), ['sort_by' => 'categorie', 'sort_order' => request('sort_by') == 'categorie' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" 
                   class="btn {{ $currentSort == 'categorie' ? 'btn-light' : 'btn-outline-light' }}">
                    Catégorie
                    @if($currentSort == 'categorie')
                        <i class="bi bi-arrow-{{ $currentOrder == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
                
                <a href="{{ route('produits.index', array_merge(request()->all(), ['sort_by' => 'prix_vente', 'sort_order' => request('sort_by') == 'prix_vente' && request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}" 
                   class="btn {{ $currentSort == 'prix_vente' ? 'btn-light' : 'btn-outline-light' }}">
                    Prix
                    @if($currentSort == 'prix_vente')
                        <i class="bi bi-arrow-{{ $currentOrder == 'asc' ? 'up' : 'down' }}"></i>
                    @endif
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        @if($produits->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix Achat (FDJ)</th>
                        <th>Prix Vente (FDJ)</th>
                        <th>Marge</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td>
                            <strong>{{ $produit->reference }}</strong>
                            <br>
                            <small class="text-muted">{{ $produit->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>{{ $produit->nom }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $produit->categorie }}</span>
                        </td>
                        <td class="text-success fw-bold">{{ $produit->prix_achat_format }}</td>
                        <td class="text-primary fw-bold">{{ $produit->prix_vente_format }}</td>
                        <td>
                            @php
                                $marge = $produit->prix_vente - $produit->prix_achat;
                            @endphp
                            @if($marge > 0)
                                <span class="text-success fw-bold">
                                    +{{ number_format($marge, 0, ',', ' ') }} FDJ
                                </span>
                            @elseif($marge < 0)
                                <span class="text-danger fw-bold">
                                    {{ number_format($marge, 0, ',', ' ') }} FDJ
                                </span>
                            @else
                                <span class="text-muted">0 FDJ</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                    <!-- Bouton Voir -->
        <a href="{{ route('produits.show', $produit) }}" class="btn btn-outline-info" 
           title="Voir les détails">
            <i class="bi bi-eye"></i>
        </a>
                                <a href="{{ route('produits.edit', $produit) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <button type="button" class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $produit->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Modal de suppression pour chaque produit -->
                            <div class="modal fade" id="deleteModal{{ $produit->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-exclamation-triangle"></i> Confirmer la suppression
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Supprimer le produit <strong>{{ $produit->nom }}</strong> ({{ $produit->reference }}) ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Annuler
                                            </button>
                                            <form action="{{ route('produits.destroy', $produit) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Affichage de {{ $produits->firstItem() }} à {{ $produits->lastItem() }} sur {{ $produits->total() }} produits
            </div>
            <div>
                {{ $produits->appends(request()->query())->links() }}
            </div>
        </div>
        
        @else
        <div class="text-center py-5">
            @if(request()->anyFilled(['search', 'categorie', 'prix_min', 'prix_max']))
                <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="text-muted mt-3">Aucun résultat trouvé</h4>
                <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('produits.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Voir tous les produits
                </a>
            @else
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="text-muted mt-3">Aucun produit enregistré</h4>
                <p class="text-muted">Commencez par ajouter votre premier produit</p>
                <a href="{{ route('produits.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter un produit
                </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection