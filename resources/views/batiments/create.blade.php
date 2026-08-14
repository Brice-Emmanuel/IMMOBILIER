@extends('layouts.app')

@section('content')
<style>
    :root {
        --immo-primary: #0f172a;
        --immo-accent: #10b981;
    }
    .form-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .form-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 25px 30px;
        color: white;
    }
    .custom-input {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        background-color: #ffffff;
        border-color: var(--immo-accent);
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.15);
    }
    .btn-submit {
        background-color: var(--immo-accent);
        color: white;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        border: none;
    }
    .btn-submit:hover {
        background-color: #059669;
        color: white;
    }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-building me-2 text-warning"></i>Ajouter un Nouveau Bâtiment</h4>
                    <p class="mb-0 text-white-50 fs-7">Renseignez les informations relatives au bâtiment</p>
                </div>
                <a href="{{ route('batiments.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('batiments.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Nom du bâtiment / Immeuble <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ex: Résidence Paix" required>
                        @error('name') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-bold text-dark">Adresse / Localisation <span class="text-danger">*</span></label>
                            <input type="text" name="adresse" class="form-control custom-input @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}" placeholder="Ex: Akwa, Rue Joyeuse" required>
                            @error('adresse') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold text-dark">Ville</label>
                            <input type="text" name="ville" class="form-control custom-input @error('ville') is-invalid @enderror" value="{{ old('ville') }}" placeholder="Ex: Douala">
                            @error('ville') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Description (Optionnel)</label>
                        <textarea name="description" rows="3" class="form-control custom-input" placeholder="Détails supplémentaires...">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('batiments.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-submit">Enregistrer le Bâtiment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection