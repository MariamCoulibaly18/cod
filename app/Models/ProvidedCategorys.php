<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidedCategorys extends Model
{
    use HasFactory;
    protected $table = 'provided_parent_categorys';

    protected $fillable = [
        'provided_id',
        'parent_id',
    ];

    
    public function provided()
    {
        return $this->belongsTo(Provided::class);
    }
    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class);
    }
    use HasFactory;
}
