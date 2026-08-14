<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant_depenses',
        'motif',
        'batiment_id',
    ];

    protected $casts = [
        'montant_depenses' => 'decimal:2',
    ];
// Une dépense est liée à un bâtiment
     
    public function batiment()
    {
        return $this->belongsTo(Batiment::class);
    }
}