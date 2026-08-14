@extends('layouts.app')

@section('content')
<style>
    .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .form-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px 30px; color: white; }
    .custom-input, .custom-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
    .custom-input:focus, .custom-select:focus { background-color: #ffffff; border-color: #10b981; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.15); }

    /* Custom Switch Container */
    .switch-card {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 50px;
    }

    /* Style du switch Bootstrap personnalisé */
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #ef4444; /* Rouge quand Occupé */
        border-color: #ef4444;
    }
    .form-switch .form-check-input:not(:checked) {
        background-color: #10b981; /* Vert quand Libre */
        border-color: #10b981;
    }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-9">
        <div class="card form-card">
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-house-door me-2 text-info"></i>Nouveau Logement</h4>
                    <p class="mb-0 text-white-50 fs-7">Ajoutez un appartement, studio ou local à un bâtiment</p>
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

                <form action="{{ route('logements.store') }}" method="POST">
                    @csrf

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Bâtiment de rattachement <span class="text-danger">*</span></label>
                            <select name="batiment_id" class="form-select custom-select @error('batiment_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un bâtiment --</option>
                                @foreach($batiments as $batiment)
                                    <option value="{{ $batiment->id }}" {{ old('batiment_id') == $batiment->id ? 'selected' : '' }}>
                                        {{ $batiment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batiment_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Numéro / Désignation</label>
                            <input type="text" name="numero" class="form-control custom-input @error('numero') is-invalid @enderror" value="{{ old('numero') }}" placeholder="Ex: Appt A12, Porte 3, Magasin 1">
                            @error('numero') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Catégorie du bien <span class="text-danger">*</span></label>
                            <select name="categorie" class="form-select custom-select @error('categorie') is-invalid @enderror" required>
                                <option value="">-- Sélectionner la catégorie --</option>
                                <option value="appartement" {{ old('categorie') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="studio" {{ old('categorie') == 'studio' ? 'selected' : '' }}>Studio</option>
                                <option value="maison" {{ old('categorie') == 'maison' ? 'selected' : '' }}>Maison</option>
                                <option value="boutique" {{ old('categorie') == 'boutique' ? 'selected' : '' }}>Boutique</option>
                                <option value="bureau" {{ old('categorie') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                            </select>
                            @error('categorie') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Loyer mensuel (FCFA) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="loyer_mensuel" class="form-control custom-input @error('loyer_mensuel') is-invalid @enderror" value="{{ old('loyer_mensuel') }}" placeholder="Ex: 150000" required>
                                <span class="input-group-text bg-light text-muted fw-bold">FCFA</span>
                            </div>
                            @error('loyer_mensuel') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- Statut réaménagé sous forme de Bouton Toggle Switch -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark d-block">Statut du logement <span class="text-danger">*</span></label>
                            <div class="switch-card">
                                <span id="statusLabel" class="fw-bold text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i> Libre / Disponible
                                </span>

                                <div class="form-check form-switch m-0 p-0">
                                    <!-- Valeur envoyée par défaut quand la case n'est PAS cochée (1 = Libre) -->
                                    <input type="hidden" name="statut" value="1">
                                    <!-- Valeur envoyée si la case EST cochée (0 = Occupé) -->
                                    <input class="form-check-input ms-0" type="checkbox" id="statutToggle" name="statut" value="0" {{ old('statut') === '0' ? 'checked' : '' }}>
                                </div>
                            </div>
                            @error('statut') <div class="text-danger small mt-1 ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Description (Optionnel)</label>
                            <textarea name="description" rows="2" class="form-control custom-input @error('description') is-invalid @enderror" placeholder="Étage, équipements...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('logements.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-success rounded-3 px-4 py-2 fw-bold" style="background-color: #10b981; border:none;">
                            Enregistrer le Logement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour gérer le libellé dynamique -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('statutToggle');
        const label = document.getElementById('statusLabel');

        function updateToggleUI() {
            if (toggle.checked) {
                label.className = 'fw-bold text-danger';
                label.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Occupé';
            } else {
                label.className = 'fw-bold text-success';
                label.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Libre / Disponible';
            }
        }

        toggle.addEventListener('change', updateToggleUI);
        updateToggleUI(); // Exécution initiale
    });
</script>
@endsection