<?php

namespace App\Models;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boutique extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'store_url',
        'consumer_key',
        'consumer_secret',
        'type_id',
        'user_id',
        'logo',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->belongsTo(BoutiqueType::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function factures(){
 
        return $this->hasMany(Facture::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function societeTransports()
    {
        return $this->hasMany(SocieteTransport::class);
    }
    public function pointVentes()
    {
        return $this->hasMany(PointVente::class);
    }
    // public function depenses()
    // {
    //     return $this->hasMany(Depense::class);
    // }
    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }
}
