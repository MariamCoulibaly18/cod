<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table = 'commandes';

    protected $fillable = [
        'status',
        'total',
        'client_id',
        'statut_livraison_id',
        'bon_de_commande'
    ];

    public function produits()
    {
        return $this->belongsToMany(Produit::class);
    }
    public function commandeProduits()
    {
        return $this->belongsToMany(CommandeProduit::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function statutLivraison()
    {
        return $this->belongsTo(StatutLivraison::class, 'statut_livraison_id');
    }
}
