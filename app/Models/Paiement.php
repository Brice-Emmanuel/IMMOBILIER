<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'locataire_id',
        'montant_paiement',
        'date_paiement',
        'date_debut_conso',
        'date_fin_conso',
    ];

    protected $casts = [
        'montant_paiement' => 'decimal:2',
        'date_paiement' => 'date',
        'date_debut_conso' => 'date',
        'date_fin_conso' => 'date',
    ];

    // --- Relations ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}