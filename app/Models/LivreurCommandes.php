<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivreurCommandes extends Model
{
    protected $fillable = [
        'order_id',
        'livreur_id',
        'accepted',
        'statut_livraison_id',
    ];

    public function livreur()
    {
        return $this->belongsTo(Livreur::class);
    }
    public function statutLivraison()
    {
        return $this->belongsTo(StatutLivraison::class, 'statut_livraison_id');
    }
    
    use HasFactory;
}
