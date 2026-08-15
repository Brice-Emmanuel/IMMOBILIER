<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'batiment_id',
        'montant_depenses',
        'motif',
    ];

    protected $casts = [
        'montant_depenses' => 'decimal:2',
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
}