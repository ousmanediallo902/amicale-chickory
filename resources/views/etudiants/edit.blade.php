@extends('layouts.app')

@section('content')
    <div class="card loyer-card">
        <div class="card-header loyer-card-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h5 mb-1">
                    <i class="bi bi-pencil-square me-2"></i>
                    Modifier l'étudiant
                </h1>
                <p class="mb-0 small">Mettre à jour les informations d'un étudiant.</p>
            </div>
            <a href="{{ route('etudiants.index') }}" class="btn btn-sm loyer-btn-light">
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

            <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" class="mt-3">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" required>
            @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $etudiant->email) }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
            @error('telephone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="amicale_id" class="form-label">Maison <span class="text-danger">*</span></label>
            <select name="amicale_id" id="amicale_id" class="form-select @error('amicale_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner une maison --</option>
                @foreach($amicales as $amicale)
                    <option value="{{ $amicale->id }}" @selected(old('amicale_id', $etudiant->amicale_id) == $amicale->id)>{{ $amicale->nom }}</option>
                @endforeach
            </select>
            @error('amicale_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="promotion" class="form-label">Promotion</label>
            <input type="text" class="form-control @error('promotion') is-invalid @enderror" id="promotion" name="promotion" value="{{ old('promotion', $etudiant->promotion) }}" placeholder="ex: L1, L2, L3">
            @error('promotion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Mettre à jour
            </button>
        </div>
            </form>
        </div>
    </div>
@endsection
