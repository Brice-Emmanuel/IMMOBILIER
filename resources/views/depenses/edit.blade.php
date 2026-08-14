@extends('layouts.app')

@section('content')
<style>
    .form-card { 
        border: none; 
        border-radius: 20px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        overflow: hidden; 
    }
    .form-header { 
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); 
        padding: 25px 30px; 
        color: white; 
    }
    .custom-input, .custom-select { 
        border-radius: 12px; 
        padding: 12px 16px; 
        border: 1px solid #cbd5e1; 
        background-color: #f8fafc; 
        transition: all 0.2s ease-in-out;
    }
    .custom-input:focus, .custom-select:focus { 
        background-color: #ffffff; 
        border-color: #2563eb; 
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.15); 
    }
    .btn-update {
        background-color: #2563eb;
        border: none;
        color: white;
        transition: background-color 0.2s ease;
    }
    .btn-update:hover {
        background-color: #1d4ed8;
        color: white;
    }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-8">
        <div class="card form-card">
            
            <!-- En-tête élégant -->
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-receipt-cutoff me-2 text-primary"></i>Modifier la Dépense</h4>
                    <p class="mb-0 text-white-50 fs-7">Mettez à jour la dépense : {{ $depense->motif }}</p>
                </div>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <!-- Corps du formulaire -->
            <div class="card-body p-4 p-md-5">

                {{-- Affichage général des erreurs --}}
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

                <form action="{{ route('depenses.update', $depense) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ligne 1 : Bâtiment concerné & Montant -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Bâtiment concerné <span class="text-danger">*</span></label>
                            <select name="batiment_id" class="form-select custom-select @error('batiment_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un bâtiment --</option>
                                @foreach($batiments as $b)
                                    <option value="{{ $b->id }}" {{ old('batiment_id', $depense->batiment_id) == $b->id ? 'selected' : '' }}>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batiment_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Montant de la dépense <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="montant_depenses" class="form-control custom-input @error('montant_depenses') is-invalid @enderror" value="{{ old('montant_depenses', $depense->montant_depenses) }}" required placeholder="Ex: 50000">
                                <span class="input-group-text bg-light text-muted fw-bold">FCFA</span>
                            </div>
                            @error('montant_depenses') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Ligne 2 : Motif de la dépense -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Motif / Description <span class="text-danger">*</span></label>
                        <input type="text" name="motif" class="form-control custom-input @error('motif') is-invalid @enderror" value="{{ old('motif', $depense->motif) }}" required placeholder="Ex: Achat ampoules et réparations">
                        @error('motif') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Boutons d'actions -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('depenses.index') }}" class="btn btn-light rounded-3 px-4 py-2 fw-semibold">Annuler</a>
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