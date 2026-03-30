@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-house-door me-2"></i>
                    @if (!empty($afficherRetards))
                        Loyers en retard / non payés
                    @else
                        Paiements de loyer
                    @endif
                </h1>
                <p class="mb-0 small">
                    @if (!empty($afficherRetards))
                        Liste des mois et étudiants avec loyers non payés.
                    @else
                        Suivi des loyers payés par les étudiants.
                    @endif
                </p>
            </div>
            @if (empty($afficherRetards))
                <div class="d-flex gap-2">
                    <a href="{{ route('loyers.export') }}" class="btn btn-sm btn-success shadow-sm">
                        <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
                    </a>
                    <a href="{{ route('loyers.create') }}" class="btn btn-sm loyer-btn-light shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nouveau paiement
                    </a>
                </div>
            @endif
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($loyers->isEmpty())
                <div class="loyer-empty text-center mb-0 py-4">
                    <i class="bi bi-info-circle fs-3 mb-2 d-block text-primary"></i>
                    @if (!empty($afficherRetards))
                        <span class="d-block">Aucun loyer en retard ou non payé pour le moment.</span>
                    @else
                        <span class="d-block">Aucun paiement de loyer enregistré pour le moment.</span>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Étudiant</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Montant (FCFA)</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loyers as $loyer)
                                <tr>
                                    <td>{{ $loyer->etudiant->nom }} {{ $loyer->etudiant->prenom }}</td>
                                    <td>{{ $loyer->mois }}</td>
                                    <td>{{ $loyer->annee }}</td>
                                    <td>{{ number_format($loyer->montant, 0, ',', ' ') }}</td>
                                    <td>
                                        @if ($loyer->statut === 'paye')
                                            <span class="badge loyer-badge-paye">Payé</span>
                                        @else
                                            <span class="badge loyer-badge-non-paye">Non payé</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('loyers.edit', $loyer) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('loyers.destroy', $loyer) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Confirmer la suppression de ce paiement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
