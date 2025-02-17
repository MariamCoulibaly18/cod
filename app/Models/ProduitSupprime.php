<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitSupprime extends Model
{
    protected $fillable = [
        'produit_id',
        'name',
    ];
    use HasFactory;
}
