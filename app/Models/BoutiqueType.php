<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoutiqueType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'icon',
        'description'
    ];

    public function boutiques()
    {
        return $this->hasMany(Boutique::class);
    }
}
