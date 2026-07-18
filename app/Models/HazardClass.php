<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_number',
        'class_description',
        'division_number',
        'division_description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'hazard_classes', 'id', 'id');
    }
}
