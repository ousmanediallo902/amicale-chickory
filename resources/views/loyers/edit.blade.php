@extends('layouts.app')

@section('content')
    <div class="card loyer-card">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-pencil-square me-2"></i>
                    Modifier un paiement de loyer
                </h1>
                <p class="mb-0 small">Mettre à jour les informations d'un paiement existant.</p>
            </div>
            <a href="{{ route('loyers.index') }}" class="btn btn-sm loyer-btn-light">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('loyers.update', $loyer) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
            <label for="etudiant_id" class="form-label">Étudiant</label>
            <select name="etudiant_id" id="etudiant_id" class="form-select @error('etudiant_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner un étudiant --</option>
                @foreach ($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" @selected(old('etudiant_id', $loyer->etudiant_id) == $etudiant->id)>
                        {{ $etudiant->nom }} {{ $etudiant->prenom }} (Promo {{ $etudiant->promotion }})
                    </option>
                @endforeach
            </select>
            @error('etudiant_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="mois" class="form-label">Mois</label>
            <select name="mois" id="mois" class="form-select @error('mois') is-invalid @enderror" required>
                <option value="">-- Mois --</option>
                @foreach ($mois as $m)
                    <option value="{{ $m }}" @selected(old('mois', $loyer->mois) == $m)>{{ $m }}</option>
                @endforeach
            </select>
            @error('mois')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="annee" class="form-label">Année</label>
            <select name="annee" id="annee" class="form-select @error('annee') is-invalid @enderror" required>
                <option value="">-- Année --</option>
                @foreach ($annees as $a)
                    <option value="{{ $a }}" @selected(old('annee', $loyer->annee) == $a)>{{ $a }}</option>
                @endforeach
            </select>
            @error('annee')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="montant" class="form-label">Montant (FCFA)</label>
            <input type="number" step="0.01" min="0" name="montant" id="montant"
                   class="form-control @error('montant') is-invalid @enderror"
                   value="{{ old('montant', $loyer->montant) }}" required>
            @error('montant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                <option value="paye" @selected(old('statut', $loyer->statut) == 'paye')>Payé</option>
                <option value="non_paye" @selected(old('statut', $loyer->statut) == 'non_paye')>Non payé</option>
            </select>
            @error('statut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Mettre à jour
            </button>
        </div>
    </form>
        </div>
    </div>
@endsection
