<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'fournisseur_id',
        'marque_id',
        'boutique_id',
        'produit_id',
        'quantite',
        'prix',
        'total',
        'visible',
        "produit_name",
    ];
    public function fournisseurMarques()
    {
        return $this->belongsTo(FournisseurMarques::class);
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
    

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
   
    use HasFactory;
}
