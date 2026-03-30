@extends('layouts.app')

@section('content')
    <div class="card loyer-card mb-4">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-receipt-cutoff me-2"></i>
                    Dépenses
                </h1>
                <p class="mb-0 small">Suivi des dépenses de l'Amicale Chicory.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('depenses.export') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
                </a>
                <a href="{{ route('depenses.create') }}" class="btn btn-sm loyer-btn-light">
                    <i class="bi bi-plus-circle me-1"></i> Nouvelle dépense
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

            @if($depenses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Montant (FCFA)</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($depenses as $depense)
                                <tr>
                                    <td>{{ ucfirst($depense->type) }}</td>
                                    <td>{{ number_format($depense->montant, 0, ',', ' ') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($depense->date)->format('d/m/Y') }}</td>
                                    <td>{{ $depense->description ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('depenses.edit', $depense->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('depenses.destroy', $depense->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette dépense ?');">
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
                    <span class="d-block">Aucune dépense enregistrée pour le moment.</span>
                    <a href="{{ route('depenses.create') }}" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-circle me-1"></i> Enregistrer une dépense
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
