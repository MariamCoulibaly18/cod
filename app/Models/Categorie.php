<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function produits()
    {
        return $this->belongsToMany(Produit::class,'produit_categorie');
    }

    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class);
    }
}
