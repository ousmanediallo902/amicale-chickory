@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-building me-2"></i>
                    Maisons / Amicales
                </h1>
                <p class="mb-0 small">Gestion des maisons de l'Amicale (foyers).</p>
            </div>
            <a href="{{ route('amicales.create') }}" class="btn btn-sm loyer-btn-light">
                <i class="bi bi-plus-circle me-1"></i> Nouvelle maison
            </a>
        </div>

        <div class="card-body">
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($amicales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Étudiants</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($amicales as $amicale)
                                <tr>
                                    <td>{{ $amicale->nom }}</td>
                                    <td>{{ $amicale->adresse ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-people me-1"></i>
                                            {{ $amicale->etudiants_count }}
                                        </span>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($amicale->description, 60) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('amicales.edit', $amicale) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('amicales.destroy', $amicale) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette maison ?');">
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
                    <span class="d-block">Aucune maison enregistrée pour le moment.</span>
                    <a href="{{ route('amicales.create') }}" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Ajouter la première
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
