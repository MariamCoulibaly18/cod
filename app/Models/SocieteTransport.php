<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocieteTransport extends Model
{
    protected $fillable = [
        'name',
        'adresse',
        'telephone',
        'boutique_id',
    ];
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function livreurs(){
        return $this->hasMany(Livreur::class);
    }
    use HasFactory;
}
