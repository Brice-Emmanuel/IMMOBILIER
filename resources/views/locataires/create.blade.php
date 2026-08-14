@extends('layouts.app')

@section('content')
<style>
    .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .form-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px 30px; color: white; }
    .custom-input, .custom-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
    .custom-input:focus, .custom-select:focus { background-color: #ffffff; border-color: #10b981; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.15); }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-9">
        <div class="card form-card">
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-person-plus me-2 text-warning"></i>Nouveau Locataire</h4>
                    <p class="mb-0 text-white-50 fs-7">Enregistrez un nouveau locataire et attribuez-lui un logement</p>
                </div>
                <a href="{{ route('locataires.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('locataires.store') }}" method="POST">
                    @csrf

                    <!-- Identité -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control custom-input @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom de famille" required>
                            @error('nom') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Prénom</label>
                            <input type="text" name="prenom" class="form-control custom-input @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom">
                            @error('prenom') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Contacts principaux -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Numéro de téléphone principal <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control custom-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Ex: 699000000" required>
                            @error('phone') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Adresse Email</label>
                            <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="exemple@email.com">
                            @error('email') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Contact Urgence, Loyer & Logement -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Numéro d'urgence</label>
                            <input type="text" name="phone_urgence" class="form-control custom-input @error('phone_urgence') is-invalid @enderror" value="{{ old('phone_urgence') }}" placeholder="Ex: 677000000">
                            @error('phone_urgence') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Loyer mensuel personnalisé (FCFA)</label>
                            <input type="number" step="0.01" name="loyer" class="form-control custom-input @error('loyer') is-invalid @enderror" value="{{ old('loyer') }}" placeholder="Par défaut si vide">
                            @error('loyer') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Logement à attribuer</label>
                            <select name="logement_id" class="form-select custom-select @error('logement_id') is-invalid @enderror">
                                <option value="">-- Aucun logement --</option>
                                @foreach($logements as $l)
                                    <option value="{{ $l->id }}" {{ old('logement_id') == $l->id ? 'selected' : '' }}>
                                        {{-- Affiche le nom/type du logement si présent, sinon le numéro/id --}}
                                        {{ $l->nom ?? $l->type ?? ('Logement N° ' . ($l->numero ?? $l->id)) }} 
                                        ({{ $l->batiment->name ?? 'Bâtiment' }} - {{ number_format($l->loyer_mensuel ?? $l->loyer ?? 0, 0, ',', ' ') }} FCFA)
                                    </option>
                                @endforeach
                            </select>
                            @error('logement_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('locataires.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-success rounded-3 px-4 py-2 fw-bold" style="background-color: #10b981; border:none;">
                            Enregistrer le Locataire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection