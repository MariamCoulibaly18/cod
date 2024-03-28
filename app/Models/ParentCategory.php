<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    protected $table = 'parent_categorys';
    use HasFactory;
    protected $fillable = [
        'nom',
    ];
    public function categorys()
    {
        return $this->hasMany(CategoryExpense::class);
    }
    public function providedCategorys()
    {
        return $this->belongsTo(ProvidedCategorys::class);
    }
}
