<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',  
        'texte',  

    ];
    public function messageries()
    {
        return $this->belongsToMany(Messagerie::class);
    }
}
