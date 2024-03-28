<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'facture_id',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
