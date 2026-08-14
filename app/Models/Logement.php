<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Logement extends Model
{
    use HasFactory;

    protected $fillable = [
    'batiment_id',
    'categorie',
    'description',
    'loyer_mensuel',
    'statut', 
];

protected $casts = [
    'loyer_mensuel' => 'decimal:2',
    'statut' => 'boolean', 
];

   // Un logement appartient à un bâtiment
    
    public function batiment()
    {
        return $this->belongsTo(Batiment::class);
    }
}