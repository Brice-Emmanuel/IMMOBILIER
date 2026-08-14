@extends('layouts.app')

@section('content')
<style>
    .form-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .form-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px 30px; color: white; }
    .custom-input, .custom-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
    .custom-input:focus, .custom-select:focus { background-color: #ffffff; border-color: #ef4444; box-shadow: 0 0 0 0.25rem rgba(239, 68, 68, 0.15); }
</style>

<div class="row justify-content-center my-4">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="form-header d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-tools me-2 text-danger"></i>Enregistrer une Dépense</h4>
                    <p class="mb-0 text-white-50 fs-7">Saisissez une charge ou travaux sur un bâtiment</p>
                </div>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('depenses.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Bâtiment concerné <span class="text-danger">*</span></label>
                        <select name="batiment_id" class="form-select custom-select @error('batiment_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner le bâtiment --</option>
                            @foreach($batiments as $bat)
                                <option value="{{ $bat->id }}" {{ old('batiment_id') == $bat->id ? 'selected' : '' }}>
                                    {{ $bat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('batiment_id') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Motif / Description de la dépense <span class="text-danger">*</span></label>
                        <input type="text" name="motif" class="form-control custom-input @error('motif') is-invalid @enderror" value="{{ old('motif') }}" placeholder="Ex: Réparation plomberie, Peinture" required>
                        @error('motif') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Montant dépensé (FCFA) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="montant_depenses" class="form-control custom-input @error('montant_depenses') is-invalid @enderror" value="{{ old('montant_depenses') }}" placeholder="Ex: 25000" required>
                                <span class="input-group-text bg-light text-muted fw-bold">FCFA</span>
                            </div>
                            @error('montant_depenses') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Date de la dépense <span class="text-danger">*</span></label>
                            <input type="date" name="date_depense" class="form-control custom-input @error('date_depense') is-invalid @enderror" value="{{ old('date_depense', date('Y-m-d')) }}" required>
                            @error('date_depense') <div class="invalid-feedback ms-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('depenses.index') }}" class="btn btn-light rounded-3 px-4 py-2">Annuler</a>
                        <button type="submit" class="btn btn-danger rounded-3 px-4 py-2 fw-bold">
                            Enregistrer la Dépense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection