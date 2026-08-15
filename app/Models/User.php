<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Imports explicites pour supprimer les soulignements rouges dans l'IDE
use App\Models\Batiment;
use App\Models\Logement;
use App\Models\Locataire;
use App\Models\Paiement;
use App\Models\Depense;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // --- Relations ---

    public function batiments()
    {
        return $this->hasMany(Batiment::class);
    }

    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    public function locataires()
    {
        return $this->hasMany(Locataire::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
}