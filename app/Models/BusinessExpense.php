<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'montant',
        'date',
        'note',
        'status',
        'category_id',
        'boutique_id',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryExpense::class);
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

}
