<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamExpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'montant',
        'date',
        'note',
        'status',
        'user_id',
        'boutique_id',
        'provided_id',
        'category_id',

    ];
    
    public function category()
    {
        return $this->belongsTo(CategoryExpense::class);
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function provided()
    {
        return $this->belongsTo(Provided::class);
    }

}
