<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messagerie extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'status_messagerie',
        'recepteur',
        'template_id',
        'api_messagerie_id',
        'statut_livraison_id',
        'boutique_id',
    ];
    public function template()
    {
        return $this->belongsTo(Template::class);
    }   
    public function apiMessagerie()
    {
        return $this->belongsTo(ApiMessagerie::class);
    }   
    public function statutLivraison()
    {
        return $this->belongsTo(StatutLivraison::class);
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }  
}
