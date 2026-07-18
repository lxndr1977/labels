<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            //
            $table->string('page_size')->default('A4');
            $table->string('page_orientation')->default('portrait');
            
            $table->decimal('page_margin_top', 5, 2)->default(1.9);
            $table->decimal('page_margin_right', 5, 2)->default(1.9);
            $table->decimal('page_margin_bottom', 5, 2)->default(1.8);
            $table->decimal('page_margin_left', 5, 2)->default(1.9);

            $table->decimal('label_width', 5, 2)->default(17.4);
            $table->decimal('label_height', 5, 2)->default(8.2);
            $table->integer('labels_per_row')->default(1);
            $table->decimal('labels_row_gap', 5, 2)->default(0.7);
            $table->decimal('labels_column_gap', 5, 2)->default(0);

            $table->decimal('product_name_top', 5, 2)->default(3.7);
            $table->decimal('product_name_left', 5, 2)->default(6.2);
            $table->decimal('product_name_width', 5, 2)->default(4.9);
            $table->decimal('product_name_height', 5, 2)->default(0.6);
            $table->string('product_name_text_align')->default('center');
            $table->string('product_name_font_size')->default('18px');

            $table->string('product_properties_visibility')->default('visible');
            $table->decimal('product_properties_left', 5, 2)->default(9.4);
            $table->decimal('product_properties_width', 5, 2)->default(1);

            $table->decimal('product_property_cure_top', 5, 2)->default(4.6);
            $table->decimal('product_property_viscosity_top', 5, 2)->default(5.1);
            $table->decimal('product_property_thickness_top', 5, 2)->default(5.6);

            $table->decimal('product_property_width', 5, 2)->default(0.4);
            $table->decimal('product_property_height', 5, 2)->default(0.4);

            $table->decimal('product_info_top', 5, 2)->default(4.2);
            $table->decimal('product_info_left', 5, 2)->default(6.1);
            $table->decimal('product_info_width', 5, 2)->default(2.1);
            $table->string('product_info_font_size')->default('7px');
            $table->decimal('product_info_line_height', 3, 2)->default(1.3);
            $table->decimal('product_info_padding', 5, 2)->default(0.15);

            $table->decimal('product_batch_top', 5, 2)->default(4.45);
            $table->decimal('product_batch_left', 5, 2)->default(6.1);
            $table->decimal('product_batch_width', 5, 2)->default(2.1);
            $table->decimal('product_batch_height', 5, 2)->default(1);
            $table->string('product_batch_font_size')->default('7px');
            $table->string('product_batch_text_align')->default('left');
            $table->decimal('product_batch_padding', 5, 2)->default(0.15);

            $table->decimal('product_barcode_top', 5, 2)->default(5.5);
            $table->decimal('product_barcode_left', 5, 2)->default(13.1);
            $table->decimal('product_barcode_width', 5, 2)->default(3);
            $table->decimal('product_barcode_height', 5, 2)->default(2);
            $table->decimal('product_barcode_padding', 5, 2)->default(0.1);

            $table->decimal('product_pictograms_top', 5, 2)->default(5.3);
            $table->decimal('product_pictograms_left', 5, 2)->default(6.1);
            $table->decimal('product_pictograms_width', 5, 2)->default(2.1);
            $table->decimal('product_pictograms_height', 5, 2)->default(1.3);
            $table->decimal('product_pictograms_padding', 5, 2)->default(0.15);
            $table->decimal('product_pictograms_image_width', 5, 2)->default(0.6);
            $table->string('product_pictograms_visibility')->default('visible');
            $table->decimal('product_pictograms_gap', 5, 2)->default(0.1);

            $table->decimal('product_weight_top', 5, 2)->default(7.2);
            $table->decimal('product_weight_left', 5, 2)->default(10);
            $table->decimal('product_weight_width', 5, 2)->default(1);
            $table->decimal('product_weight_height', 5, 2)->default(0.9);
            $table->string('product_weight_font_size')->default('8px');
            $table->string('product_weight_text_align')->default('center');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            $table->dropColumn([
                'page_size',
                'page_orientation',
                'page_margin_top',
                'page_margin_right',
                'page_margin_bottom',
                'page_margin_left',
                'label_width',
                'label_height',
                'labels_per_row',
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
                'product_batch_top',
                'product_batch_left',
                'product_batch_width',
                'product_batch_height',
                'product_batch_font_size',
                'product_batch_text_align',
                'product_batch_padding',
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
                'product_weight_text_align'
            ]);
        });
    }
};
