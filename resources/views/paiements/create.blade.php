@extends('layouts.app')

@section('content')
<style>
    .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .form-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px 30px; color: white; }
    .custom-input, .custom-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
    .custom-input:focus, .custom-select:focus { background-color: #ffffff; border-color: #10b981; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.15); }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-cash-stack me-2 text-success"></i>Enregistrer un Paiement</h4>
                    <p class="mb-0 text-white-50 fs-7">Saisissez la réception du loyer d'un locataire</p>
                </div>
                <a href="{{ route('paiements.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">

                {{-- Affichage général des erreurs si validation échoue --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Veuillez corriger les erreurs suivantes :</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('paiements.store') }}" method="POST">
                    @csrf

                    <!-- Selection du Locataire -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Locataire <span class="text-danger">*</span></label>
                        <select name="locataire_id" class="form-select custom-select @error('locataire_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner le locataire --</option>
                            @foreach($locataires as $loc)
                                <option value="{{ $loc->id }}" {{ old('locataire_id') == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->nom }} {{ $loc->prenom }} 
                                    @if($loc->logement) (Logement: {{ $loc->logement->numero }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('locataire_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Montant et Date de paiement -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Montant payé (FCFA) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="montant_paiement" class="form-control custom-input @error('montant_paiement') is-invalid @enderror" value="{{ old('montant_paiement') }}" placeholder="Ex: 100000" required>
                                <span class="input-group-text bg-light text-muted fw-bold">FCFA</span>
                            </div>
                            @error('montant_paiement') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Date du paiement <span class="text-danger">*</span></label>
                            <input type="date" name="date_paiement" class="form-control custom-input @error('date_paiement') is-invalid @enderror" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                            @error('date_paiement') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Période de consommation (Ajoutée pour correspondre au contrôleur) -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Début période de consommation <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut_conso" class="form-control custom-input @error('date_debut_conso') is-invalid @enderror" value="{{ old('date_debut_conso') }}" required>
                            @error('date_debut_conso') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Fin période de consommation <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin_conso" class="form-control custom-input @error('date_fin_conso') is-invalid @enderror" value="{{ old('date_fin_conso') }}" required>
                            @error('date_fin_conso') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Note / Observations -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Note / Période (Optionnel)</label>
                        <input type="text" name="note" class="form-control custom-input @error('note') is-invalid @enderror" placeholder="Ex: Loyer du mois d'Août 2026" value="{{ old('note') }}">
                        @error('note') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('paiements.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-success rounded-3 px-4 py-2 fw-bold" style="background-color: #10b981; border:none;">
                            Valider le Paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection