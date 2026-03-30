@extends('layouts.app')

@section('content')
    <div class="card loyer-card">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-coin me-2"></i>
                    Nouvelle cotisation
                </h1>
                <p class="mb-0 small">Enregistrer une nouvelle cotisation pour un étudiant.</p>
            </div>
            <a href="{{ route('cotisations.index') }}" class="btn btn-sm loyer-btn-light">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cotisations.store') }}" method="POST" class="mt-3">
                @csrf

                <div class="form-group mb-3">
            <label for="type" class="form-label">Type de cotisation <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">-- Sélectionner --</option>
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="etudiant_id" class="form-label">Étudiant <span class="text-danger">*</span></label>
            <select name="etudiant_id" id="etudiant_id" class="form-select @error('etudiant_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner un étudiant --</option>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->nom }} {{ $etudiant->prenom }}
                    </option>
                @endforeach
            </select>
            @error('etudiant_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="mois" class="form-label">Mois <span class="text-danger">*</span></label>
                <select name="mois" id="mois" class="form-select @error('mois') is-invalid @enderror" required>
                    <option value="">-- Mois --</option>
                    @foreach($mois as $m)
                        <option value="{{ $m }}" {{ old('mois') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
                @error('mois')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="annee" class="form-label">Année <span class="text-danger">*</span></label>
                <select name="annee" id="annee" class="form-select @error('annee') is-invalid @enderror" required>
                    <option value="">-- Année --</option>
                    @foreach($annees as $a)
                        <option value="{{ $a }}" {{ old('annee') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
                @error('annee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="montant" class="form-label">Montant (FCFA) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('montant') is-invalid @enderror" id="montant" name="montant" value="{{ old('montant') }}" required>
                @error('montant')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                <option value="non_paye" {{ old('statut', 'non_paye') == 'non_paye' ? 'selected' : '' }}>Non payée</option>
                <option value="paye" {{ old('statut') == 'paye' ? 'selected' : '' }}>Payée</option>
            </select>
            @error('statut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Enregistrer
            </button>
        </div>
            </form>
        </div>
    </div>
@endsection
