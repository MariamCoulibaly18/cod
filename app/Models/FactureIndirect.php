<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureIndirect extends Model
{
    use HasFactory;

    protected $table = 'facture_indirect';
    
    protected $fillable = [
        'facture_type_id',
        'type',
    ];
}
