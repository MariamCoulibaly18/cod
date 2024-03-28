<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provided extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function providedCategorys()
    {
        return $this->belongsTo(ProvidedCategorys::class);
    }
    public function teamExpense()
    {
        return $this->hasMany(TeamExpense::class);
    }
}
