<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'parent_category_id',
        'type_depense_id',
    ];
    public function businessExpense()
    {
        return $this->belongsToMany(BusinessExpense::class);
    }
    public function teamExpense()
    {
        return $this->belongsToMany(TeamExpense::class);
    }
    public function providedCategorys()
    {
        return $this->belongsTo(ProvidedCategorys::class);
    }
    public function typeDepense()
    {
        return $this->belongsTo(TypeDepenses::class);
    }
    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class);
    }
}
