@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-piggy-bank me-2"></i>
                    Subventions & aides
                </h1>
                <p class="mb-0 small">Recettes externes : autorités, partenaires, donateurs.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('subventions.export') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
                </a>
                <a href="{{ route('subventions.create') }}" class="btn btn-sm loyer-btn-light">
                    <i class="bi bi-plus-circle me-1"></i> Nouvelle subvention
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($subventions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Source</th>
                                <th>Type</th>
                                <th>Montant (FCFA)</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subventions as $subvention)
                                <tr>
                                    <td>{{ $subvention->source }}</td>
                                    <td>{{ ucfirst($subvention->type) }}</td>
                                    <td>{{ number_format($subvention->montant, 0, ',', ' ') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($subvention->date)->format('d/m/Y') }}</td>
                                    <td>{{ $subvention->description ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('subventions.edit', $subvention) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('subventions.destroy', $subvention) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette subvention / aide ?');">
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
                    <span class="d-block">Aucune subvention ou aide enregistrée pour le moment.</span>
                </div>
            @endif
        </div>
    </div>
@endsection
