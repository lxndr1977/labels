<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Pictogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'image',
    ];

    public function products() 
    {
        return $this->belongsToMany(Product::class, 'product_pictogram');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->attributes['image']);
    }
}
