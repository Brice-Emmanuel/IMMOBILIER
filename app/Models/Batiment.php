<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Imports explicites pour éliminer les erreurs d'analyse de VS Code
use App\Models\User;
use App\Models\Logement;
use App\Models\Depense;

class Batiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'adresse',
        'ville',
    ];

    // --- Relations ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
}