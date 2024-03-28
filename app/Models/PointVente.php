<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointVente extends Model
{
    protected $fillable = [
        'client',
        'ville',
        'telephone',
        'type_payement',
        'type_echange_commercial',
        'total_commande',
        'order_id',
        'customer_id',
        'boutique_id',
    ];
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    use HasFactory;
}
