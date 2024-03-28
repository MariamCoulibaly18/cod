<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'logo',
    ];
  
    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_marques', 'fournisseur_id', 'marque_id');
    }
    public function fournisseurMarques()
    {
        return $this->belongsTo(FournisseurMarques::class);
    }
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
