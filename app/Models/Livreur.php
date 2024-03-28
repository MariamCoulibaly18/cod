<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    protected $fillable = [
        'adresse',
        'telephone',
        'matricule',
        'status',
        'societeTransport_id',
        'user_id',
    ];
    public function societeTransport()
    {
        return $this->belongsTo(SocieteTransport::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
