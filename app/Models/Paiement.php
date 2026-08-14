<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_paiement',
        'date_paiement',
        'date_debut_conso',
        'date_fin_conso',
        'locataire_id',
    ];

    protected $casts = [
        'montant_paiement' => 'decimal:2',
        'date_paiement' => 'date',
        'date_debut_conso' => 'date',
        'date_fin_conso' => 'date',
    ];

   // Un paiement est effectué par un locataire
     
    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}