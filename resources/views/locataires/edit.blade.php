@extends('layouts.app')

@section('content')
<style>
    .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .form-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px 30px; color: white; }
    .custom-input, .custom-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; background-color: #f8fafc; transition: all 0.2s ease-in-out; }
    .custom-input:focus, .custom-select:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15); }
    .btn-update { background-color: #2563eb; border: none; color: white; transition: background-color 0.2s ease; }
    .btn-update:hover { background-color: #1d4ed8; color: white; }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-9">
        <div class="card form-card">
            
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Modifier le Locataire</h4>
                    <p class="mb-0 text-white-50 fs-7">Mettez à jour les informations de {{ $locataire->nom }} {{ $locataire->prenom }}</p>
                </div>
                <a href="{{ route('locataires.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4 border-0 shadow-sm">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Veuillez corriger les erreurs :</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('locataires.update', $locataire) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom & Prénom -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control custom-input @error('nom') is-invalid @enderror" value="{{ old('nom', $locataire->nom) }}" required placeholder="Ex: Dupont">
                            @error('nom') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Prénom</label>
                            <input type="text" name="prenom" class="form-control custom-input @error('prenom') is-invalid @enderror" value="{{ old('prenom', $locataire->prenom) }}" placeholder="Ex: Jean">
                            @error('prenom') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Email & Téléphone principal -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Adresse Email</label>
                            <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" value="{{ old('email', $locataire->email) }}" placeholder="Ex: jean.dupont@email.com">
                            @error('email') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control custom-input @error('phone') is-invalid @enderror" value="{{ old('phone', $locataire->phone) }}" required placeholder="Ex: 600000000">
                            @error('phone') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Urgence, Loyer & Choix du Logement -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Téléphone d'Urgence</label>
                            <input type="text" name="phone_urgence" class="form-control custom-input @error('phone_urgence') is-invalid @enderror" value="{{ old('phone_urgence', $locataire->phone_urgence) }}" placeholder="Contact d'un proche">
                            @error('phone_urgence') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Loyer personnalisé (FCFA)</label>
                            <input type="number" step="0.01" name="loyer" class="form-control custom-input @error('loyer') is-invalid @enderror" value="{{ old('loyer', $locataire->loyer) }}" placeholder="Ex: 150000">
                            @error('loyer') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Logement attribué</label>
                            <select name="logement_id" class="form-select custom-select @error('logement_id') is-invalid @enderror">
                                <option value="">-- Aucun logement --</option>
                                @foreach($logements as $l)
                                    <option value="{{ $l->id }}" {{ old('logement_id', $locataire->logement_id) == $l->id ? 'selected' : '' }}>
                                        Logement N° {{ $l->numero ?? $l->id }} ({{ $l->batiment->name ?? 'Bâtiment' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('logement_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Boutons d'actions -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('locataires.index') }}" class="btn btn-light rounded-3 px-4 py-2 fw-semibold">Annuler</a>
                        <button type="submit" class="btn btn-update rounded-3 px-4 py-2 fw-bold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection