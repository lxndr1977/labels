<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabelGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'page_size',
        'page_orientation',
        'page_margin_top',
        'page_margin_right',
        'page_margin_bottom',
        'page_margin_left',
        'printing_area_width',
        'printing_area_height',
        'label_width',
        'label_height',
        'labels_per_row',
        'labels_per_page',
        'labels_row_gap',
        'labels_column_gap',
        'product_name_top',
        'product_name_left',
        'product_name_width',
        'product_name_height',
        'product_name_text_align',
        'product_name_font_size',
        'product_properties_visibility',
        'product_properties_left',
        'product_properties_width',
        'product_property_cure_top',
        'product_property_viscosity_top',
        'product_property_thickness_top',
        'product_property_width',
        'product_property_height',
        'product_info_top',
        'product_info_left',
        'product_info_width',
        'product_info_font_size',
        'product_info_line_height',
        'product_info_padding',
        'product_info_visibility',
        'product_batch_top',
        'product_batch_left',
        'product_batch_width',
        'product_batch_height',
        'product_batch_font_size',
        'product_batch_text_align',
        'product_batch_padding',
        'product_batch_visibility',
        'product_barcode_top',
        'product_barcode_left',
        'product_barcode_width',
        'product_barcode_height',
        'product_barcode_padding',
        'product_pictograms_top',
        'product_pictograms_left',
        'product_pictograms_width',
        'product_pictograms_height',
        'product_pictograms_padding',
        'product_pictograms_image_width',
        'product_pictograms_visibility',
        'product_pictograms_gap',
        'product_weight_top',
        'product_weight_left',
        'product_weight_width',
        'product_weight_height',
        'product_weight_font_size',
        'product_weight_text_align',
        'proportion_top',
        'proportion_left',
        'proportion_width',
        'proportion_height',
        'proportion_text_align',
        'proportion_font_size',
        'product_description_visibility',
        'product_description_top',
        'product_description_left',
        'product_description_width',
        'product_description_height',
        'product_description_text_align',
        'product_description_font_size',
        'product_description_visibility',
    ];  

    public function products()
    {
        return $this->belongsTo(Product::class, 'label_groups', 'id', 'label_group_id');
    }
}
