@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-coin me-2"></i>
                    Cotisations
                </h1>
                <p class="mb-0 small">Suivi des cotisations des étudiants de l'Amicale Chicory.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('cotisations.export') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
                </a>
                <a href="{{ route('cotisations.create') }}" class="btn btn-sm loyer-btn-light">
                    <i class="bi bi-plus-circle me-1"></i> Nouvelle cotisation
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($cotisations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Étudiant</th>
                                <th>Type</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Montant (FCFA)</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cotisations as $cotisation)
                                <tr>
                                    <td>
                                        {{ optional($cotisation->etudiant)->nom }} {{ optional($cotisation->etudiant)->prenom }}
                                    </td>
                                    <td>
                                        @switch($cotisation->type)
                                            @case('vidange')
                                                Vidange
                                                @break
                                            @case('eau')
                                                Eau
                                                @break
                                            @case('electricite')
                                                Électricité
                                                @break
                                            @case('evenement')
                                            @default
                                                Événement
                                        @endswitch
                                    </td>
                                    <td>{{ $cotisation->mois }}</td>
                                    <td>{{ $cotisation->annee }}</td>
                                    <td>{{ number_format($cotisation->montant, 0, ',', ' ') }}</td>
                                    <td>
                                        @if($cotisation->statut === 'paye')
                                            <span class="badge loyer-badge-paye">Payée</span>
                                        @else
                                            <span class="badge loyer-badge-non-paye">Non payée</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('cotisations.edit', $cotisation->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('cotisations.destroy', $cotisation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette cotisation ?');">
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
            @else
                <div class="loyer-empty text-center mb-0 py-4">
                    <i class="bi bi-info-circle fs-3 mb-2 d-block text-primary"></i>
                    <span class="d-block">Aucune cotisation enregistrée pour le moment.</span>
                    <a href="{{ route('cotisations.create') }}" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Enregistrer une cotisation
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
