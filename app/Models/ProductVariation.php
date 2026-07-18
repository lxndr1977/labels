<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'package_id',
        'label_group_id',
        'weight',
        'unit_measurement_id',
        'gtin',
    ];

    protected $casts = [
        'weight' => 'decimal:3',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function package() {
        return $this->belongsTo(Package::class); 
    }

    public function labelGroup() {
        return $this->belongsTo(LabelGroup::class);
    }

    public function unitMeasurement() {
        return $this->belongsTo(UnitMeasurement::class);
    }

    public function formattedWeight()
    {
        return (floor($this->weight) == $this->weight)
            ? number_format($this->weight, 0)
            : number_format($this->weight, 3);
    }
}
