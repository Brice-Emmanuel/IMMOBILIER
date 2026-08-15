<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Imports explicites pour supprimer la ligne rouge sous User, Batiment et Locataire
use App\Models\User;
use App\Models\Batiment;
use App\Models\Locataire;

class Logement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'batiment_id',
        'numero',
        'categorie',
        'description',
        'loyer_mensuel',
        'statut',
    ];

    protected $casts = [
        'loyer_mensuel' => 'decimal:2',
        'statut' => 'boolean',
    ];

    // --- Relations ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batiment()
    {
        return $this->belongsTo(Batiment::class);
    }

    public function locataires()
    {
        return $this->hasMany(Locataire::class);
    }
}