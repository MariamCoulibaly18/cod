<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'name',
        'adresse',
        'telephone',
        'type_id',
        'boutique_id',
    ];
    public function marques()
    {
        return $this->belongsToMany(Marque::class, 'fournisseur_marques', 'fournisseur_id', 'marque_id');
    }

    public function type()
{
    return $this->belongsTo(Type::class);
}
    public function fournisseurMarques()
    {
        return $this->belongsTo(FournisseurMarques::class);
    }
    
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    use HasFactory;
}
