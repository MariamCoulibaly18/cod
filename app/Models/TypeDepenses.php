<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDepenses extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function category_depenses()
    {
        return $this->belongsToMany(CategoryDepenses::class);
    }
}
