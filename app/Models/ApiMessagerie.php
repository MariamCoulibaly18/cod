<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiMessagerie extends Model
{
    use HasFactory;
    protected $table = 'api_messageries';

    protected $fillable = [
        'api_name',
        'api_key',
        'api_secret',
    ];

    public function messageries()
    {
        return $this->belongsToMany(Messagerie::class);
    }
}
