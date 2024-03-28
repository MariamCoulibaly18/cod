<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'sku',
        'description',
        'prix',
        'quantite',
        'stock_status',
        'pub_status',
        'permalien',
        'boutique_id',
        'marque_id',

    ];


    public function categories()
    {
        return $this->belongsToMany(Categorie::class,'produit_categorie');
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
}
