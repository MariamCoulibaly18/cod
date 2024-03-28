<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'type',
    ];
    public function fournisseur()
    {
        return $this->hasMany(Fournisseur::class);
    }
    use HasFactory;
}
