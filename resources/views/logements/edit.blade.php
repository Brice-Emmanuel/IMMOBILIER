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
                    <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-warning"></i>Modifier le Logement</h4>
                    <p class="mb-0 text-white-50 fs-7">Mettez à jour les informations du logement</p>
                </div>
                <a href="{{ route('logements.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4 border-0 shadow-sm">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Veuillez corriger les erreurs suivantes :</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('logements.update', $logement) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Bâtiment <span class="text-danger">*</span></label>
                            <select name="batiment_id" class="form-select custom-select @error('batiment_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un bâtiment --</option>
                                @foreach($batiments as $batiment)
                                    <option value="{{ $batiment->id }}" {{ old('batiment_id', $logement->batiment_id) == $batiment->id ? 'selected' : '' }}>
                                        {{ $batiment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batiment_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Numéro / Désignation</label>
                            <input type="text" name="numero" class="form-control custom-input @error('numero') is-invalid @enderror" value="{{ old('numero', $logement->numero) }}" placeholder="Ex: Appt A12">
                            @error('numero') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Catégorie <span class="text-danger">*</span></label>
                            <select name="categorie" class="form-select custom-select @error('categorie') is-invalid @enderror" required>
                                <option value="appartement" {{ old('categorie', $logement->categorie) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="studio" {{ old('categorie', $logement->categorie) == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="maison" {{ old('categorie', $logement->categorie) == 'maison' ? 'selected' : '' }}>Maison</option>
                                <option value="boutique" {{ old('categorie', $logement->categorie) == 'boutique' ? 'selected' : '' }}>Boutique</option>
                                <option value="bureau" {{ old('categorie', $logement->categorie) == 'bureau' ? 'selected' : '' }}>Bureau</option>
                            </select>
                            @error('categorie') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Loyer mensuel (FCFA) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="loyer_mensuel" class="form-control custom-input @error('loyer_mensuel') is-invalid @enderror" value="{{ old('loyer_mensuel', $logement->loyer_mensuel) }}" required>
                                <span class="input-group-text bg-light text-muted fw-bold">FCFA</span>
                            </div>
                            @error('loyer_mensuel') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="statut" id="statutSwitch" value="1" {{ old('statut', $logement->statut) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2 text-dark" for="statutSwitch">
                                    Logement disponible à la location
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Description</label>
                            <textarea name="description" rows="2" class="form-control custom-input @error('description') is-invalid @enderror">{{ old('description', $logement->description) }}</textarea>
                            @error('description') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('logements.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-warning rounded-3 px-4 py-2 fw-bold text-dark">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection