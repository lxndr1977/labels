<?php

namespace App\Models;

use App\Models\LabelGroup;
use App\Models\ProductPictogram;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'comercial_name',
        'internal_name',
        'label_name',
        'chemycal_type',
        'liquid_substance',
        'technical_features',
        'un_number',
        'production_instruction',
        'signal_word',
        'hazard_class_id',
        'cure',
        'viscosity',
        'thickness',
        'proportion',
        'is_active'
    ];

    public function batches() 
    {
        return $this->hasMany(Batch::class);
    }

    public function hazardClass() 
    {
        return $this->hasOne(HazardClass::class, 'id', 'hazard_class_id');
    }

    public function pictograms() 
    {
        return $this->belongsToMany(Pictogram::class, 'product_pictogram');
    }

    public function labelGroup()
    {
        return $this->hasOne(LabelGroup::class, 'id', 'label_group_id');
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
