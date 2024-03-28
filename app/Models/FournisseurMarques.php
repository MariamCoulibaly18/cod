<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FournisseurMarques extends Model
{
    protected $table = 'fournisseur_marques';

    protected $fillable = [
        'fournisseur_id',
        'marque_id',
    ];

    
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
