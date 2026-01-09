@extends('layout.app')

@section('title', 'Gestion des Alertes')

@section('actions')
    @if($alertes->where('vue', false)->count() > 0)
        <form action="{{ route('alertes.marquer-toutes-vues') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-all"></i> Tout marquer comme vu
            </button>
        </form>
    @endif
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-bell"></i> Historique des Alertes</h5>
            <span class="badge bg-light text-primary">
                {{ $alertes->where('vue', false)->count() }} non lues
            </span>
        </div>
        <div class="card-body">
            @if($alertes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Produit</th>
                                <th>Message</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alertes as $alerte)
                                <tr class="{{ $alerte->vue ? '' : 'table-warning' }}">
                                    <td>{{ $alerte->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $alerte->type == 'stock_bas' ? 'bg-danger' : 'bg-warning' }}">
                                            {{ $alerte->type }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($alerte->produit)
                                            <a href="{{ route('produits.edit', $alerte->produit) }}">
                                                {{ $alerte->produit->nom }}
                                            </a>
                                        @else
                                            <span class="text-muted">Produit supprimé</span>
                                        @endif
                                    </td>
                                    <td>{{ $alerte->message }}</td>
                                    <td>
                                        @if($alerte->vue)
                                            <span class="badge bg-success">Vu</span>
                                        @else
                                            <span class="badge bg-warning">Non vu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if(!$alerte->vue)
                                                <form action="{{ route('alertes.marquer-vue', $alerte) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Marquer comme vu">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('alertes.destroy', $alerte) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $alertes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="text-muted mt-3">Aucune alerte</h4>
                    <p class="text-muted">Tout est sous contrôle pour le moment</p>
                </div>
            @endif
        </div>
    </div>
@endsection