<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutLivraison extends Model
{
    use HasFactory;
    protected $table = 'statut_livraisons';
    protected $fillable = [
        'status',  
    ];
    public function commandes()
    {
        return $this->belongsToMany(Commande::class);
    }
    public function livreurCommandes()
    {
        return $this->belongsToMany(LivreurCommandes::class);
    }
    public function messageries()
    {
        return $this->belongsToMany(Messagerie::class);
    }
}
