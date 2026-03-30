@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-calendar-event me-2"></i>
                    Événements
                </h1>
                <p class="mb-0 small">Gestion des événements de l'Amicale Chicory.</p>
            </div>
            <a href="{{ route('evenements.create') }}" class="btn btn-sm loyer-btn-light">
                <i class="bi bi-plus-circle me-1"></i> Nouvel événement
            </a>
        </div>

        <div class="card-body">
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($evenements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evenements as $evenement)
                                <tr>
                                    <td>{{ $evenement->titre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($evenement->date)->format('d/m/Y') }}</td>
                                    <td>{{ $evenement->lieu ?? '-' }}</td>
                                    <td>{{ Str::limit($evenement->description, 60) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('evenements.edit', $evenement->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('evenements.destroy', $evenement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet événement ?');">
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
                    <span class="d-block">Aucun événement enregistré pour le moment.</span>
                    <a href="{{ route('evenements.create') }}" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Créer un événement
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
