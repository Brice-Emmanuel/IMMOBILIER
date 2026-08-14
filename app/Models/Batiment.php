<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Batiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'adresse',
        'user_id',
        'ville',
    ];

    // Un bâtiment appartient à un utilisateur
     
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un bâtiment contient plusieurs logements
     
    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    
     // Un bâtiment peut avoir plusieurs dépenses
     
    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
}