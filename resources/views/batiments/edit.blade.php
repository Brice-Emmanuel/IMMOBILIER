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
                    <h4 class="fw-bold mb-1"><i class="bi bi-building me-2 text-primary"></i>Modifier le Bâtiment</h4>
                    <p class="mb-0 text-white-50 fs-7">Mettez à jour les informations de {{ $batiment->name }}</p>
                </div>
                <a href="{{ route('batiments.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
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

                <form action="{{ route('batiments.update', $batiment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ligne 1 : Nom du Bâtiment & Ville -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Nom du bâtiment <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" value="{{ old('name', $batiment->name) }}" required placeholder="Ex: Résidence Les Palmiers">
                            @error('name') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Ville <span class="text-danger">*</span></label>
                            <input type="text" name="ville" class="form-control custom-input @error('ville') is-invalid @enderror" value="{{ old('ville', $batiment->ville) }}" required placeholder="Ex: Douala">
                            @error('ville') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Ligne 2 : Adresse complète -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Adresse complète</label>
                        <textarea name="adresse" class="form-control custom-input @error('adresse') is-invalid @enderror" rows="3" placeholder="Ex: Quartier Akwa, Rue Deido">{{ old('adresse', $batiment->adresse) }}</textarea>
                        @error('adresse') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Boutons d'actions -->
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('batiments.index') }}" class="btn btn-light rounded-3 px-4 py-2 fw-semibold">Annuler</a>
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