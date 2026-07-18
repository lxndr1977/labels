<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'weight',
    ];

    public function batch() {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function setWeightAttribute($value) 
    {
        $value = str_replace ( ',', '.', $value);

        $this->attributes['weight'] = floatval($value);
    }

    public function product() 
    {
        return $this->hasOneThrough(
         'App\Models\Product','App\Models\Batch', 'id', 'id', 'batch_id', 'product_id');
    }

    public function supplier() 
    {
        return $this->hasOneThrough(
         'App\Models\Supplier','App\Models\Batch', 'id', 'id', 'supplier_id', 'id');
    }
}
