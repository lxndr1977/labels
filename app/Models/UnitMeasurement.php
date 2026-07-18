<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    use HasFactory;

    protected $table = 'units_measurement';
    
    protected $fillable = [
        'unit_name',
        'unit_symbol',
    ];

    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
