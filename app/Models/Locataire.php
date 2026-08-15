<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Imports explicites pour supprimer les soulignements rouges
use App\Models\User;
use App\Models\Logement;
use App\Models\Paiement;

class Locataire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logement_id',
        'nom',
        'prenom',
        'email',
        'phone',
        'phone_urgence',
        'loyer',
    ];

    protected $casts = [
        'loyer' => 'decimal:2',
    ];

    // --- Relations ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}