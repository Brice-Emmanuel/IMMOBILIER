<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Locataire extends Model
{
    use HasFactory;

    protected $fillable = [
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

    //Un locataire peut effectuer plusieurs paiements
     
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
 //un locataire peut avoir un logement
    public function logement() 
    {
        return $this->belongsTo(Logement::class);
    }
}