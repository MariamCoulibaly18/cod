<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'status',
        'payement_status',
        'is_direct',
        'facture_type_id',
        'boutique_id',
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function payements()
    {
        return $this->hasMany(Payement::class);
    }

    public function facture_direct()
    {
        return $this->hasOne(FactureDirect::class);
    }

    public function facture_indirect()
    {
        return $this->hasOne(FactureIndirect::class);
    }
}
