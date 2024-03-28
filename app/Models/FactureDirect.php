<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureDirect extends Model
{
    use HasFactory;
    protected $table = 'facture_direct';

    protected $fillable = [
        'client',
        'email',
        'total',
        'pdf',
    ];
}
