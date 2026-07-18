<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'supplier_id',
        'identification',
        'expiration_month',
        'expiration_year',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function hazardClass() 
    {
        return $this->hasOneThrough(
         'App\Models\HazardClass','App\Models\Product', 'id', 'id', 'product_id', 'hazard_class_id');
    }
}
