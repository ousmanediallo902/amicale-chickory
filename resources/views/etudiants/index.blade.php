@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-people me-2"></i>
                    Liste des étudiants
                </h1>
                <p class="mb-0 small">Gestion des membres de l'Amicale.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('etudiants.export') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
                </a>
                <a href="{{ route('etudiants.create') }}" class="btn btn-sm loyer-btn-light">
                    <i class="bi bi-plus-circle me-1"></i> Nouvel étudiant
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

            @if(count($etudiants) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Maison</th>
                                <th>Promotion</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->prenom }}</td>
                                    <td>{{ $etudiant->email ?? '-' }}</td>
                                    <td>{{ $etudiant->telephone ?? '-' }}</td>
                                    <td>{{ optional($etudiant->amicale)->nom ?? '-' }}</td>
                                    <td>{{ $etudiant->promotion ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
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
                    <span class="d-block">Aucun étudiant enregistré pour le moment.</span>
                    <a href="{{ route('etudiants.create') }}" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Ajouter le premier
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
